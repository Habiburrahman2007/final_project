<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Article;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class ArticleControl extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Admin | Kontrol artikel')]
    public $articles;
    public $user;
    public $category = 'All';
    public $categories = [];
    public $search = '';
    public $status = 'All';

    public $perPage = 9;
    public $totalArticles = 0;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadCategories();
        $this->loadArticles();
    }

    public function updatedSearch()
    {
        $this->resetPageData();
        $this->loadArticles();
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function searchPost()
    {
        $this->resetPageData();
        $this->loadArticles();
    }

    protected function resetPageData()
    {
        $this->perPage = 9;
        $this->loadArticles();
    }

    public function loadArticles()
    {

        $this->totalArticles = Article::when($this->category !== 'All', function ($query) {
            $query->whereHas('category', fn($q) => $q->where('name', $this->category));
        })
            ->when($this->status !== 'All', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', '%' . $this->search . '%'));
                });
            })
            ->count();

        $this->articles = Article::with(['user', 'category', 'likes', 'comments'])
            ->when($this->category !== 'All', function ($query) {
                $query->whereHas('category', fn($q) => $q->where('name', $this->category));
            })
            ->when($this->status !== 'All', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', '%' . $this->search . '%'));
                });
            })
            ->latest()
            ->take($this->perPage)
            ->get()
            ->map(function ($article) {
                $article->isLiked = $article->likes->where('user_id', $this->user->id ?? null)->count() > 0;
                return $article;
            });
    }

    #[On('toggleStatus')]
    public function toggleStatus($id)
    {
        $article = Article::find($id);
        if (!$article) return;

        $article->status = $article->status === 'active' ? 'banned' : 'active';
        $article->save();

        $this->loadArticles();

        $this->dispatch(
            'statusUpdated',
            $article->status === 'banned'
                ? 'Artikel berhasil diblokir.'
                : 'Artikel berhasil diaktifkan.'
        );
    }

    public function loadMore()
    {
        if ($this->perPage < $this->totalArticles) {
            $this->perPage += 9;
            $this->loadArticles();
        }
    }

    public function toggleLike($articleId)
    {
        $user = $this->user;
        $article = Article::find($articleId);

        if (!$article || !$user) return;

        $existingLike = Like::where('user_id', $user->id)
            ->where('article_id', $articleId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'article_id' => $articleId,
            ]);
        }

        $this->loadArticles();
    }

    public function setCategory($category)
    {
        $this->category = $category;
        $this->resetPageData();
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPageData();
    }

    public function render()
    {
        return view('livewire.admin.article-control');
    }
}

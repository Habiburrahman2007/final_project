<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Article;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class Dashboard extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]

    #[Url(history: true)]
    public $articles = [];
    public $user;
    public $category = 'All';
    public $categories = [];
    public $search = '';
    public $isLoadingMore = false;
    public $perPage = 9;
    public $totalArticles;
    public $page = 1;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadCategories();
        $this->loadArticles();
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadArticles();
    }

    public function searchPost()
    {
        $this->resetPage();
        $this->loadArticles();
    }

    public function resetPage()
    {
        $this->perPage = 9;
        $this->page = 1;
    }

    public function loadArticles()
    {
        $query = Article::with(['user', 'category', 'likes', 'comments'])
            ->where('status', 'active')
            ->whereHas('user', fn($q) => $q->where('banned', false))
            ->when(
                $this->category !== 'All',
                fn($q) => $q->whereHas('category', fn($q2) => $q2->where('name', $this->category))
            )
            ->when(
                $this->search,
                fn($q) =>
                $q->where(
                    fn($q2) =>
                    $q2->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', fn($q3) => $q3->where('name', 'like', '%' . $this->search . '%'))
                )
            )
            ->latest();

        $this->totalArticles = $query->count();

        $this->articles = $query->take($this->perPage)->get()
            ->map(function ($article) {
                $article->isLiked = $article->likes->where('user_id', $this->user->id ?? null)->count() > 0;
                return $article;
            });
    }

    public function loadMore()
    {
        if ($this->perPage < $this->totalArticles) {
            $this->isLoadingMore = true;
            usleep(300000);
            $this->perPage += 9;
            $this->loadArticles();
            $this->isLoadingMore = false;
        }
    }

    public function toggleLike($articleId)
    {
        $user = $this->user;
        if (!$user) return;

        $like = Like::where('user_id', $user->id)
            ->where('article_id', $articleId)
            ->first();

        if ($like) {
            $like->delete();
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
        $this->resetPage();
        $this->loadArticles();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

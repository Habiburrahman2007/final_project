<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class Statistic extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Admin | Statistik')]

    public $totalUsers;
    public $totalCategories;
    public $totalArticles;
    public $totalLikes;
    public $totalComments;
    public $categoryNames = [];
    public $categoryArticleCounts = [];
    public $categoryColors = [];
    public $popularArticles = [];
    public $colorOptions = [
        'bg-danger' => 'Merah',
        'bg-success' => 'Hijau',
        'bg-warning' => 'Kuning',
        'bg-primary' => 'Biru',
    ];

    public function mount()
    {
        $this->calculateTotals();
        $this->loadChartData();
        $this->popularArticles = Article::where('status', 'active')
            ->with(['category:id,name,color', 'user:id,name'])
            ->withCount('likes') 
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();
    }

    public function calculateTotals()
    {
        $this->totalUsers = User::where('banned', false)->count();
        $this->totalCategories = Category::count();
        $this->totalArticles = Article::where('status', 'active')->count();
        $this->totalComments = Comment::count();
        $this->totalLikes = Like::count();
    }

    public function loadChartData()
    {
        $categories = Category::withCount(['articles' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('articles_count', '>', 0) // Hanya kategori dengan artikel
            ->orderBy('articles_count', 'desc')
            ->limit(10) // Batasi 10 kategori teratas
            ->get();

        $this->categoryNames = $categories->pluck('name')->toArray();
        $this->categoryArticleCounts = $categories->pluck('articles_count')->toArray();
        $this->categoryColors = $categories->pluck('color')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.statistic', [
            'colorOptions' => $this->colorOptions,
        ]);
    }
}
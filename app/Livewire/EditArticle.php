<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class EditArticle extends Component
{
    use WithFileUploads;

    public $articleId;
    public $title;
    public $content = '';
    public $category_id;
    public $image;
    public $oldImage;
    public $categories;

    #[Layout('components.layouts.app')]
    #[Title('Edit artikel')]

    public function mount($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Authorization: Only article owner can edit
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->content = $article->content ?? '';
        $this->category_id = $article->category_id;
        $this->oldImage = $article->image;
        $this->categories = Category::all();
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $article = Article::findOrFail($this->articleId);

        // Double-check authorization before update
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $slug = Str::slug($this->title);
        $slugCount = Article::where('slug', $slug)
            ->where('id', '!=', $this->articleId)
            ->count();

        if ($slugCount > 0) {
            $slug = $slug . '-' . time();
        }
        if ($this->image) {
            if ($this->oldImage && Storage::disk('public')->exists($this->oldImage)) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('articles', 'public');
        } else {
            $imagePath = $this->oldImage;
        }

        // Sanitize HTML content to prevent XSS
        $sanitizedContent = \App\Helpers\HtmlSanitizer::sanitize($this->content);

        $article->update([
            'title' => $this->title,
            'content' => $sanitizedContent,
            'category_id' => $this->category_id,
            'slug' => $slug,
            'image' => $imagePath,
        ]);
        session()->flash('article_updated', true);
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.article.edit-article');
    }
}

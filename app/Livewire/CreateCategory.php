<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Category;

class CreateCategory extends Component
{
    public $name;
    public $color;

    #[Layout('components.layouts.app')]
    #[Title('Admin | Tambah Kategori')]
    public function render()
    {
        return view('livewire.admin.create-category');
    }

    public $colorOptions = [
        'bg-danger' => 'Merah',
        'bg-success' => 'Hijau',
        'bg-warning' => 'Kuning',
        'bg-primary' => 'Biru',
    ];

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2|unique:categories,name',
            'color' => 'required|in:' . implode(',', array_keys($this->colorOptions)),
        ]);

        Category::create([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        session()->flash('category_created', true);
        return redirect()->to('/admin/category');
    }
}

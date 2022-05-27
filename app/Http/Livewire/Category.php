<?php

namespace App\Http\Livewire;

use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Category extends Component
{
    use Actions;

    public $items;

    public $category;

    protected $listeners = ['saved' => 'render'];

    public function save()
    {
        $this->validate([
            'category' => 'required|string|unique:categories,name'
        ], [
            'category.required' => 'Nama kategori harus diisi!',
            'category.string' => 'Nama kategori harus berupa string!',
            'category.unique' => 'Kategori sudah terdaftar di database'
        ]);

        $category = ModelsCategory::create([
            'code' => $this->category,
            'name' => $this->category
        ]);

        $this->emit('saved');

        activity()->by(Auth::user())->log('Menambagkan kategori ' . $category->name);

        return $this->notification()->notify([
            'title' => 'Berhasil',
            'description' => 'Kategori berhasil disimpan',
            'icon' => 'success'
        ]);
    }

    public function mount()
    {
        $this->items = ModelsCategory::all();
    }

    public function render()
    {
        return view('livewire.category');
    }
}

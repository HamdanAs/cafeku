<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use WireUi\Traits\Actions;

class AddMenu extends Component
{
    use WithFileUploads, Actions;

    public $categories;

    public $form = [
        'name' => '',
        'category_id' => 0,
        'price' => 0,
        'description' => ''
    ];

    public $image;

    protected $rules = [
        'form.name' => 'required',
        'form.category_id' => 'required|not_in:0',
        'form.price' => ['required', 'integer', 'not_in:0'],
        'form.description' => 'required|max:255',
        'image' => 'required',
    ];

    protected $messages = [
        'form.name.required' => 'Nama menu harus diisi!',
        'form.price.required' => 'Harga harus diisi!',
        'form.price.integer' => 'Harga harus angka!',
        'form.price.not_in' => 'Harga tidak boleh berisi 0!',
        'form.category_id.not_in' => 'Kategori harus diisi!',
        'form.category_id.required' => 'Kategori harus diisi!',
        'form.description.required' => 'Deskripsi harus diisi!',
        'form.description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter',
        'image.required' => 'Gambar harus diisi!',
    ];

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
    ];

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function save()
    {
        $this->validate();

        $img = $this->storeImage();

        $category = Category::find($this->form['category_id']);

        $category->products()->create([
            'name' => $this->form['name'],
            'price' => $this->form['price'],
            'picture' => $img,
            'description' => $this->form['description'],
            'stock' => 0
        ]);

        $this->form = [
            'name' => '',
            'price' => 0,
            'category_id' => 0,
            'description' => '',
        ];

        $this->image = '';

        activity()->causedBy(Auth::user())->log('Membuat menu baru');

        return $this->notification()->confirm([
            'title'       => 'Data tersimpan!',
            'description' => 'Data menu telah berhasil disimpan',
            'icon'        => 'success',
            'accept'      => [
                'label' => 'Kembali ke daftar menu',
                'url' => '/manager/menu',
            ]
        ]);
    }

    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }

        $img   = Image::make($this->image)->encode('png');
        $img->resize(300, 300);
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.add-menu');
    }
}

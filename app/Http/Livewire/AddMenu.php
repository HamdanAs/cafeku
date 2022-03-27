<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AddMenu extends Component
{
    use WithFileUploads;

    public $form = [
        'code' => '',
        'name' => '',
        'price' => 0,
    ];

    public $image;

    protected $rules = [
        'form.code' => 'required|unique:products,code',
        'form.name' => 'required',
        'form.price' => ['required', 'integer', 'not_in:0'],
        'image' => 'required'
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

        Product::create([
            'code' => $this->form['code'],
            'name' => $this->form['name'],
            'price' => $this->form['price'],
            'picture' => $img,
            'stock' => 0
        ]);

        $this->form = [
            'code' => '',
            'name' => '',
            'price' => 0,
            'image' => ''
        ];

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }

        $img   = Image::make($this->image)->encode('jpg');
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function render()
    {
        return view('livewire.add-menu');
    }
}

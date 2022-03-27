<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class EditMenu extends Component
{
    public $menu;

    public $form = [
        'code' => '',
        'name' => '',
        'price' => '',
    ];

    public $image;

    protected $rules = [
        'form.code' => 'required',
        'form.name' => 'required',
        'form.price' => ['required', 'integer', 'not_in:0'],
        'image' => 'nullable'
    ];

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
    ];

    public function mount($id)
    {
        $this->menu = Product::find($id);
        $this->form['code'] = $this->menu->code;
        $this->form['name'] = $this->menu->name;
        $this->form['price'] = $this->menu->price;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function save(Product $product)
    {
        $this->validate();

        $data = [
            'code' => $this->form['code'],
            'name' => $this->form['name'],
            'price' => $this->form['price'],
            'stock' => 0
        ];

        if($this->image){
            Storage::delete($this->image);

            $img = $this->storeImage();

            $data = array_merge($data, ['picture' => $img]);
        }

        $product->update($data);

        $this->form = [
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
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
        $img->resize(320);
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function render()
    {
        return view('livewire.edit-menu');
    }
}

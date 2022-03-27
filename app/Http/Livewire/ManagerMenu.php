<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ManagerMenu extends Component
{

    public $menus;

    protected $listeners = ['stockSub' => 'subMenu', 'stockAdd' => 'addMenu'];

    public function mount()
    {
        $this->menus = Product::all();
    }

    public function addMenu($id)
    {
        $product = Product::find($id);
        $stock = Product::query()->find($id)->getAttributeValue('stock');

        $product->update([ 'stock' => ++$stock ]);

        $this->menus = Product::all();
    }

    public function subMenu($id)
    {
        $product = Product::find($id);
        $stock = Product::query()->find($id)->getAttributeValue('stock');

        $product->update([ 'stock' => --$stock ]);

        $this->menus = Product::all();
    }

    public function deleteMenu($id)
    {
        $product = Product::find($id);

        $product->delete();

        $this->menus = Product::all();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.manager-menu');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;

class ManagerMenu extends Component
{

    use Actions;

    public $search;

    protected $listeners = ['stockSub' => 'subMenu', 'stockAdd' => 'addMenu'];

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
        return $this->dialog()->confirm([
            'title' => 'Apakah anda yakin?',
            'description' => 'Apakah anda ingin menghapus menu ini?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Ya, saya ingin menghapus ini',
                'method' => 'deleted',
                'params' => $id
            ],
            'reject' => [
                'label' => 'Tidak, saya tidak ingin'
            ]
        ]);
    }

    public function deleted($id)
    {
        $product = Product::find($id);

        $product->delete();

        $this->menus = Product::all();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.manager-menu', [
            'menus' => $this->search === null ?
                Product::paginate(6) :
                Product::query()->where('name', 'like', '%' . $this->search . '%')->paginate(6)
        ]);
    }
}

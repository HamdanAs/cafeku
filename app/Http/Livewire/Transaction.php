<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transaction extends Component
{
    use WithPagination;

    public $search;

    private $cart;

    protected $updateQueryString = ['search'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.transaction', [
            'menus' => $this->search === null ?
                Product::paginate(6) :
                Product::query()->where('name', 'like', '%' . $this->search . '%')->paginate(6)
        ]);
    }

    public function addToCart(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $userID = Auth::user()->id;

        \Cart::session($userID)->add([
            'id' => $productId,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'associatedModel' => $product
        ]);

        $this->emit('cartInserted');
    }
}

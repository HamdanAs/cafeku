<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Cart extends Component
{
    use LivewireAlert;

    protected $listeners = ['cartInserted' => 'render', 'cartUpdated' => 'render'];

    public function render()
    {
        $items = \Cart::session(Auth::user()->id)->getContent();
        $items = $items->sort();
        $total = \Cart::getTotal();

        return view('livewire.cart', compact('items', 'total'));
    }

    public function addQty($id)
    {
        \Cart::session(Auth::user()->id)->update($id, [
            'quantity' => 1
        ]);

        $this->emit('cartUpdated');
    }

    public function removeQty($id)
    {
        \Cart::session(Auth::user()->id)->update($id, [
            'quantity' => -1
        ]);

        $this->emit('cartUpdated');
    }

    public function deleteItem($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);

        $this->emit('cartUpdated');
    }

    public function process()
    {
        $items = \Cart::session(Auth::user()->id)->getContent();

        if($items->count() === 0){
            return $this->alert('error', 'Keranjang masih kosong!', [
                'toast' => false,
                'position' => 'center'
            ]);
        }

        return redirect(route('cashier.transaction.process'));
    }
}

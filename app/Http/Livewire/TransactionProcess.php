<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TransactionProcess extends Component
{
    use LivewireAlert;

    public $form = [
        'customer' => '',
        'payment' => 0
    ];

    protected $rules = [
        'form.customer' => 'required',
        'form.payment' => 'required|not_in:0'
    ];

    public function submit()
    {
        $this->validate();

        $total = \Cart::session(Auth::user()->id)->getTotal();

        if($this->form['payment'] < $total){
            return $this->alert('warning', 'Uang pembayaran kurang!', [
                'toast' => false,
                'position' => 'center',
                'timer' => 1000
            ]);
        }

        $order = Order::create([
            'customer_name' => $this->form['customer'],
            'total' => $total,
            'payment' => $this->form['payment'],
            'status' => Order::EATING,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()->addDays(2)
        ]);

        $items = \Cart::session(Auth::user()->id)->getContent();

        foreach ($items as $item) {
            $order->details()->create([
                'product_id' => $item->id,
                'qty' => $item->quantity,
                'total' => $item->price * $item->quantity
            ]);
        }

        $recharge = $this->form['payment'] - $total;

        \Cart::clear();

        $this->clearInput();

        activity()->causedBy(Auth::user())->log('Membuat transaksi sebesar ' . formatRupiah($order->total));

        return $this->flash('success', "Transaksi berhasil kembaliannya adalah $recharge", [
            'toast' => false,
            'position' => 'center',
            'timer' => null
        ], route('cashier.transaction'));
    }

    public function clearInput()
    {
        $this->form = [
            'table' => '',
            'payment' => 0
        ];
    }

    public function render()
    {
        $items = \Cart::session(Auth::user()->id)->getContent();
        $total = \Cart::session(Auth::user()->id)->getTotal();

        return view('livewire.transaction-process', compact('items', 'total'));
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionHistory extends Component
{
    public $lastOrders;

    public $modalData = [
        'orderDetails' => [],
        'total' => 0
    ];

    public $form = [
        'customer' => '',
        'payment' => 0
    ];

    public function setModalData($id)
    {
        $order = Order::query()
            ->whereBelongsTo(Auth::user())
            ->with(['details', 'details.product'])
            ->whereDate('created_at', Carbon::today())
            ->find($id);

        $this->modalData['orderDetails'] = $order->details;
        $this->modalData['total'] = $order->total;

        $this->form['customer'] = $order->customer_name;
        $this->form['payment'] = $order->payment;
    }

    public function mount()
    {
        $this->lastOrders = Order::query()
            ->whereBelongsTo(Auth::user())
            ->whereDate('created_at', Carbon::today())
            ->get();
    }

    public function render()
    {
        return view('livewire.transaction-history');
    }
}

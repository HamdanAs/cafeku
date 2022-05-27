<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CashierDashboard extends Component
{
    public $salesCountToday;
    public $salesCount;
    public $mostBoughtMenu;
    public $lastOrders;

    public $form = [
        'customer' => '',
        'payment' => 0
    ];

    public $modalData = [
        'orderDetails' => [],
        'total' => 0
    ];

    public function setModalData($id)
    {
        $order = Order::query()
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
        $this->mostBoughtMenu = Product::query()
            ->withSum('orders', 'qty')
            ->orderBy('orders_sum_qty', 'desc')
            ->get()[0];

        $this->lastOrders = Order::query()
            ->whereBelongsTo(Auth::user())
            ->take(5)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

            // dd($this->lastOrders);

        $this->salesCountToday = Order::query()->whereBelongsTo(Auth::user())->whereDate('created_at', Carbon::today())->count();
        $this->salesCount = Order::query()->whereBelongsTo(Auth::user())->count();
    }

    public function render()
    {
        return view('livewire.cashier-dashboard');
    }
}

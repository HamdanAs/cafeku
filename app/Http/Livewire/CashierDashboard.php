<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class CashierDashboard extends Component
{
    public $salesCountToday;
    public $salesCount;

    public function mount()
    {
        $this->salesCountToday = Order::query()->whereDate('created_at', Carbon::today())->count();
        $this->salesCount = Order::query()->count();
    }

    public function render()
    {
        return view('livewire.cashier-dashboard');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesReport extends Component
{
    public $dateFrom;

    public $dateTo;

    public $cashier;

    public $cashiers;

    public function mount()
    {
        $this->cashiers = Role::query()
            ->with('users')
            ->whereHas('users', function(Builder $query){
                $query->where('role_id', 4);
            })->first();
    }

    public function renderReport()
    {
        $query = null;

        $dateFrom = Carbon::parse($this->dateFrom);
        $dateTo = Carbon::parse($this->dateTo);

        if ($this->dateFrom || $this->dateTo) {
            $query = "?dateFrom=$dateFrom";
        }

        if ($this->dateFrom && $this->dateTo) {
            $query = "?dateFrom=$dateFrom&dateTo=$dateTo";
        }

        if ($this->cashier) {
            $query = "?cashier=$this->cashier";
        }

        if ($this->cashier && $this->dateFrom && $this->dateTo) {
            $query = "?dateFrom=$dateFrom&dateTo=$dateTo&cashier=$this->cashier";
        }

        if (!$this->cashier && !$this->dateFrom && !$this->dateTo) {
            $query = '';
        }

        activity()->causedBy(Auth::user())->log('Melihat laporan pendapatan');

        return redirect("/manager/report/sales/pdf$query");
    }

    public function render()
    {
        $transactions = null;

        if ($this->dateFrom || $this->dateTo) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereDate('created_at', Carbon::parse($this->dateFrom))
                ->paginate(10);
        }

        if ($this->dateFrom && $this->dateTo) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereBetween('created_at', [Carbon::parse($this->dateFrom), Carbon::parse($this->dateTo)])
                ->paginate(10);
        }

        if ($this->cashier) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereHas('user', function ($query) {
                    $query->where('id', $this->cashier);
                })
                ->paginate(10);
        }

        if (!$this->cashier && !$this->dateFrom && !$this->dateTo) {
            $transactions = Order::query()->with('user')->withSum('details', 'qty')->paginate(10);
        }

        return view('livewire.sales-report', compact('transactions'));
    }
}

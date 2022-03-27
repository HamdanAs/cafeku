<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class ManagerDashboard extends Component
{
    public $salesToday;
    public $salesThisMonth;
    public $dailyRevenue;
    public $monthlyRevenue;

    private $firstRun = true;
    private $colors = [
        '#f6ad55',
        '#fc8181',
        '#90cdf4'
    ];
    public function mount()
    {
        $this->salesToday = Order::query()->whereDate('created_at', Carbon::today())->count();
        $this->salesThisMonth = Order::query()->whereMonth('created_at', Carbon::now()->month)->count();
        $this->dailyRevenue = Order::query()->whereDate('created_at', Carbon::today())->sum('total');
        $this->monthlyRevenue = Order::query()->whereMonth('created_at', Carbon::now()->month)->sum('total');
    }

    private function setRevenueForChart()
    {
        return Order::query()->orderBy('created_at')->get();
    }

    private function setColumnChartModel($data, $colors)
    {
        return $data->groupBy('name')->take(3)
            ->reduce(
                function (ColumnChartModel $columnChartModel, $data, $key) use ($colors) {
                    $name = $data->first()->name;
                    $value = $data->first()->orders_sum_qty;
                    $index = Str::slug($key);

                    $result = $columnChartModel->addColumn($name, $value, $colors[$index]);

                    return $result;
                },
                LivewireCharts::columnChartModel()
                    ->setAnimated($this->firstRun)
            );
    }

    private function setPieChartModel($data){
        return $data->groupBy('name')
            ->reduce(function (PieChartModel $pieChartModel, $data) {
                $type = $data->first()->name;
                $value = $data->first()->orders_sum_qty;

                return $pieChartModel->addSlice($type, $value, randColor());
            }, LivewireCharts::pieChartModel()
                //->setTitle('Expenses by Type')
                // ->setAnimated($this->firstRun)
                ->withOnSliceClickEvent('onSliceClick')
                //->withoutLegend()
                ->legendPositionRight()
                ->legendHorizontallyAlignedCenter()
                // ->setDataLabelsEnabled($this->showDataLabels)
                ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
            );
    }

    private function setLineChartModel($data)
    {
        return $data->groupBy('created_at')
            ->reduce(function (PieChartModel $pieChartModel, $data) {
                $type = $data->first()->name;
                $value = $data->first()->orders_sum_qty;

                return $pieChartModel->addSlice($type, $value, randColor());
            }, LivewireCharts::pieChartModel()
                //->setTitle('Expenses by Type')
                // ->setAnimated($this->firstRun)
                ->withOnSliceClickEvent('onSliceClick')
                //->withoutLegend()
                ->legendPositionRight()
                ->legendHorizontallyAlignedCenter()
                // ->setDataLabelsEnabled($this->showDataLabels)
                ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665'])
            );
    }

    public function render()
    {
        $mostBoughtMenus = Product::query()
            ->withSum('orders', 'qty')
            ->orderBy('orders_sum_qty', 'desc')
            ->get();

        $colors = arrayWithKey($this->colors, $mostBoughtMenus->toArray(), 'name');

        $columnChartModel = $this->setColumnChartModel($mostBoughtMenus, $colors);

        $pieChartModel = $this->setPieChartModel($mostBoughtMenus);

        $lineChartModel = $this->setLineChartModel($this->setRevenueForChart());

        return view('livewire.manager-dashboard',
            compact(
                'columnChartModel',
                'pieChartModel',
                'lineChartModel',
                'mostBoughtMenus')
            );
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ManagerDashboard extends Component
{
    public $salesToday;
    public $salesThisMonth;
    public $dailyRevenue;
    public $monthlyRevenue;
    public $chartMonth;
    public $chartYear;

    private $firstRun = true;

    public function mount()
    {
        $this->salesToday = Order::query()->whereDate('created_at', Carbon::today())->count();
        $this->salesThisMonth = Order::query()->whereMonth('created_at', Carbon::now()->month)->count();
        $this->dailyRevenue = Order::query()->whereDate('created_at', Carbon::today())->sum('total');
        $this->monthlyRevenue = Order::query()->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $this->chartMonth = 03;
        $this->chartYear = 2022;
    }

    private function setRevenueForChart()
    {
        $order = Order::query()
            ->groupBy('date')
            ->whereMonth("created_at", $this->chartMonth)
            ->whereYear('created_at', $this->chartYear)
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('sum(total) as total')
            ));

        return $order;
    }

    public function changeChart()
    {
        $order = Order::query()
            ->groupBy('date')
            ->whereMonth("created_at", $this->chartMonth)
            ->whereYear('created_at', $this->chartYear)
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('sum(total) as total'),
            ));

        $this->setLineChartModel($order);
    }

    private function setColumnChartModel($data)
    {
        return $data->groupBy('name')->take(3)
            ->reduce(
                function (ColumnChartModel $columnChartModel, $data, $key) {
                    $name = $data->first()->name;
                    $value = $data->first()->orders_sum_qty;

                    $result = $columnChartModel->addColumn($name, $value, randColor());

                    return $result;
                },
                LivewireCharts::columnChartModel()
                    ->setAnimated($this->firstRun)
            );
    }

    private function setPieChartModel($data)
    {
        return $data->groupBy('name')
            ->reduce(
                function (PieChartModel $pieChartModel, $data) {
                    $type = $data->first()->name;
                    $value = (int) $data->first()->orders_sum_qty;

                    return $pieChartModel->addSlice($type, $value, randColor());
                },
                LivewireCharts::pieChartModel()
                    //->setTitle('Expenses by Type')
                    ->setAnimated($this->firstRun)
                    //->withoutLegend()
                    ->legendPositionRight()
                    ->legendHorizontallyAlignedCenter()
                    // ->setDataLabelsEnabled($this->showDataLabels)
                    ->setSparklineEnabled(true)
            );
    }

    private function setLineChartModel($data)
    {
        return $data->groupBy('date')
            ->reduce(
                function (LineChartModel $lineChartModel, $data) {
                    $type = Carbon::createFromFormat('Y-m-d', $data->first()->date)->format('d');
                    $value = $data->first()->total;

                    return $lineChartModel->addPoint($type, $value);
                },
                LivewireCharts::lineChartModel()
                    //->setTitle('Expenses by Type')
                    ->setAnimated($this->firstRun)
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
            // ->whereNot('orders_sum_qty', null)
            ->get();

        $mostBoughtCategories = Category::query()
            ->with('orders')
            ->withSum('orders', 'qty')
            // ->withAggregate('products.orders', 'qty', 'sum')
            ->get();

        $columnChartModel = $this->setColumnChartModel($mostBoughtMenus);

        $pieChartModel = $this->setPieChartModel($mostBoughtCategories);

        $lineChartModel = $this->setLineChartModel($this->setRevenueForChart());

        $ordersMonth = Order::query()
            ->distinct()
            ->get([
                DB::raw('Month(created_at) as month')
            ]);

        $ordersYear = Order::query()
            ->distinct()
            ->get([
                DB::raw('year(created_at) as year')
            ]);
        return view(
            'livewire.manager-dashboard',
            compact(
                'columnChartModel',
                'pieChartModel',
                'lineChartModel',
                'mostBoughtMenus',
                'ordersMonth',
                'ordersYear'
            )
        )->with([
            'activities' => Activity::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }
}

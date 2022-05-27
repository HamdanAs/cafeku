<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function transactionReport(Request $request)
    {
        $transactions = null;

        if ($request->query('dateFrom') || $request->query('dateTo')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereDate('created_at', Carbon::parse($request->query('dateFrom')))
                ->get();
        }

        if ($request->query('dateFrom') && $request->query('dateTo')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereBetween('created_at', [Carbon::parse($request->query('dateFrom')), Carbon::parse($request->query('dateTo'))])
                ->get();
        }

        if ($request->query('cashier')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereHas('user', function ($query) use ($request) {
                    $query->where('id', $request->query('cashier'));
                })
                ->get();
        }

        if (!$request->query('cashier') && !$request->query('dateFrom') && !$request->query('dateTo')) {
            $transactions = Order::query()->with('user')->withSum('details', 'qty')->get();
        }

        // dd($transactions);
        // dd($cashiers);

        view()->share('datas', $transactions);
        $pdf = Pdf::loadView('reports.transaction-report');

        return $pdf->download();
    }

    public function salesReport(Request $request)
    {
        $transactions = null;

        if ($request->query('dateFrom') || $request->query('dateTo')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereDate('created_at', Carbon::parse($request->query('dateFrom')))
                ->get();
        }

        if ($request->query('dateFrom') && $request->query('dateTo')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereBetween('created_at', [Carbon::parse($request->query('dateFrom')), Carbon::parse($request->query('dateTo'))])
                ->get();
        }

        if ($request->query('cashier')) {
            $transactions = Order::query()
                ->with('user')
                ->withSum('details', 'qty')
                ->whereHas('user', function ($query) use ($request) {
                    $query->where('id', $request->query('cashier'));
                })
                ->get();
        }

        if (!$request->query('cashier') && !$request->query('dateFrom') && !$request->query('dateTo')) {
            $transactions = Order::query()->with('user')->withSum('details', 'qty')->get();
        }

        $transactionSum = $transactions->sum('total');

        // dd($transactionSum);

        // dd($transactions);
        // dd($cashiers);

        view()->share('datas', $transactions);
        view()->share('total', $transactionSum);
        $pdf = Pdf::loadView('reports.sales-report');

        return $pdf->download();
    }
}

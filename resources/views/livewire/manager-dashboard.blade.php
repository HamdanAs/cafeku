<div class="bg-white rounded-lg border shadow-md p-4 h-auto">
    <div class="p-4 grid grid-cols-4 gap-4">
        <div class="max-w-sm card">
            <div class="flex flex-col items-center py-10">
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesToday }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan Hari Ini</span>
            </div>
        </div>
        <div class="max-w-sm card">
            <div class="flex flex-col items-center py-10">
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesThisMonth }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan Bulan Ini</span>
            </div>
        </div>
        <div class="max-w-sm card">
            <div class="flex flex-col items-center py-10">
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ formatRupiah($dailyRevenue) }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan Hari Ini</span>
            </div>
        </div>
        <div class="max-w-sm card">
            <div class="flex flex-col items-center py-10">
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ formatRupiah($monthlyRevenue) }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan Bulan Ini</span>
            </div>
        </div>
    </div>

    <div class="p-4 grid grid-cols-3 grid-row-4 gap-4 h-full">
        <div class="card p-2 col-span-3 order-1">
            <h5 class="text-center font-bold">Grafik Pertumbuhan Pendapatan Bulan {{ $month }}</h5>
            <livewire:livewire-line-chart :line-chart-model="$lineChartModel" />
        </div>
        <div class="card p-2 col-span-2 order-2">
            <h5 class="text-center font-bold">Penjualan Menu Terlaris</h5>
            <livewire:livewire-column-chart :column-chart-model="$columnChartModel" />
        </div>
        <div class="card p-2 row-span-2 order-3">
            <h5 class="text-center font-bold">Menu Terlaris</h5>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 p-2">
                @foreach ($mostBoughtMenus->take(10) as $menu)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/{{ 'storage/'. $menu->picture }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $menu->name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ formatRupiah($menu->price) }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card p-2 col-span-2 order-4">
            <h5 class="text-center font-bold">3 Menu Terlaris</h5>
            <livewire:livewire-pie-chart :pie-chart-model="$pieChartModel" />
        </div>
    </div>
</div>

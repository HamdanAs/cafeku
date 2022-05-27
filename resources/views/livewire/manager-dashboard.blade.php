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
            <h5 class="text-center font-bold">Grafik Pertumbuhan Pendapatan</h5>

            <form class="flex gap-4" wire:submit.prevent="changeChart">
                <x-select wire:change="selectChange" class="mb-4" label="Bulan" placeholder="Pilih bulan" wire:model="chartMonth">
                    @foreach ($ordersMonth as $order)
                    <x-select.option label="{{ $order->month }}" value="{{ $order->month }}" />
                    @endforeach
                </x-select>

                <x-select class="mb-4" label="Tahun" placeholder="Pilih tahun" wire:model="chartYear">
                    @foreach ($ordersYear as $order)
                    <x-select.option label="{{ $order->year }}" value="{{ $order->year }}" />
                    @endforeach
                </x-select>
            </form>

            <livewire:livewire-line-chart key="{{ $lineChartModel->reactiveKey() }}" :line-chart-model="$lineChartModel" />
        </div>
        <div class="card p-2 col-span-2 order-2">
            <h5 class="text-center font-bold">Penjualan Menu Terlaris</h5>

            <livewire:livewire-column-chart :column-chart-model="$columnChartModel" />
        </div>
        <div class="card p-2 row-span-2 order-3">
            <h5 class="text-center font-bold">Menu Terlaris</h5>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 p-2">
                @foreach ($mostBoughtMenus->take(5) as $menu)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/{{ 'storage/'. $menu->picture }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $menu->name }}
                            </p>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ formatRupiah($menu->price) }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    Terjual : {{ $menu->orders_sum_qty }}
                                </p>
                            </div>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card p-2 col-span-2 order-4">
            <h5 class="text-center font-bold">Chart Kategori</h5>
            <livewire:livewire-pie-chart :pie-chart-model="$pieChartModel" />
        </div>
        <div class="card p-2 col-span-3 order-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Pelaku
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aktifitas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Waktu
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $activity->causer?->username }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $activity->description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $activity->created_at }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

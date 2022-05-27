<div class="p-4">
    <nav class="flex mb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('manager.report') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Laporan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Laporan Transaksi</a>
                </div>
            </li>
        </ol>
    </nav>

    <h5 class="text-xl font-bold leading-none text-gray-900 mb-4 dark:text-white">Laporan Transaksi</h5>

    <div class="grid grid-cols-1 gap-4">
        <div class="bg-white rounded-lg border shadow-md p-4">
            <x-card title="Filter and Export">
                <div class="flex gap-4">
                    <x-datetime-picker label="Dari tanggal" placeholder="Appointment Date" wire:model="dateFrom" />
                    <x-datetime-picker label="Sampai tanggal" placeholder="Appointment Date" wire:model="dateTo" />
                    <x-select label="Pilih kasir" placeholder="Pilih kasir" wire:model="cashier">
                        @foreach ($cashiers->users as $cashier)
                        <x-select.option label="{{ $cashier->username }}" value="{{ $cashier->id }}" />
                        @endforeach
                    </x-select>
                    <x-button wire:click="renderReport" primary label="Export PDF" />
                </div>
            </x-card>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Transaksi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Transaksi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Barang
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Kasir
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $transaction->created_at }}
                        </th>
                        <td class="px-6 py-4">
                            {{ formatRupiah($transaction->total) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaction->details_sum_qty }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $transaction->user?->username }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</div>

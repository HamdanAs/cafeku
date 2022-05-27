<div class="p-4 grid grid-cols-1 gap-4">
    <div class="bg-white rounded-lg border shadow-md p-4">
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center py-10">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesCount }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center py-10">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesCountToday }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan Hari Ini</span>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center justify-center h-full">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white mt-2">Menu Terlaris</h5>
                    <div class="h-full mb-2 flex flex-col w-full items-center bg-white rounded-lg md:flex-row md:max-w-full dark:bg-gray-800">
                        <div class="w-48">
                            <img class="object-cover w-3/5 mx-auto rounded-t-lg md:rounded-none md:rounded-l-lg" src="/{{ 'storage/' . $mostBoughtMenu?->picture }}" alt="">
                        </div>
                        <div class="flex flex-col p-4">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $mostBoughtMenu->name }}</h5>

                            <p class="mb-3 text-left font-sm text-gray-700 dark:text-gray-400">{{ formatRupiah($mostBoughtMenu->price) }}</p>

                            <p class="mb-3 text-left font-sm text-gray-700 dark:text-gray-400">Terjual : {{ $mostBoughtMenu->orders_sum_qty }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center">
                    <div class="flex justify-between items-center mb-4 w-full px-4">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white mt-2">Transaksi Terakhir</h5>
                        <a href="" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                            Lihat semua
                        </a>
                    </div>
                    @forelse ($lastOrders as $order)
                    <li wire:click="setModalData({{ $order->id }})" onclick="$openModal('blurModal')" class="w-full pl-4 py-2 border-b border-gray-200 dark:border-gray-600 flex hover:bg-gray-100 cursor-pointer">
                        <div class="w-11/12">
                            <span class="flex justify-between items-end">
                                <span class="flex flex-col">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Nama Pelanggan : {{ $order->customer_name }}</span>
                                    <span>{{ $order->created_at->diffForHumans() }}</span>
                                </span>
                                <span class="font-bold">
                                    {{ formatRupiah($order->total) }}
                                </span>
                            </span>
                        </div>
                    </li>
                    @empty
                        Belum ada transaksi
                    @endforelse
                </div>
            </div>
        </div>

        <x-modal.card blur wire:model="blurModal">
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white rounded-lg border shadow-md p-4">
                    <form>
                        <div class="relative z-0 mb-6 w-full group">
                            <input disabled type="text" name="form.customer" wire:model.lazy="form.customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                            <label for="floating_email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Meja</label>
                            @error('form.customer')
                            <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 mb-6 w-full group">
                            <input disabled type="text" name="form.payment" wire:model.lazy="form.payment" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                            <label for="floating_email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Bayar</label>
                            @error('form.payment')
                            <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between border-b-2 pb-2 items-center">
                            <h5 class="">Detail Transaksi</h5>
                        </div>

                        <div class="w-full flex justify-evenly mb-2 border-b-2 space-x-4">
                            <span class="w-1/5">Gambar</span>
                            <span class="w-2/5">Nama Menu</span>
                            <span class="w-1/5">Qty</span>
                            <span class="w-1/5">Subtotal</span>
                        </div>

                        @forelse ($modalData['orderDetails'] as $order)
                        <div class="w-full flex justify-evenly mb-2 space-x-4 items-center @if ($loop->last)
                            border-b-2 pb-2
                         @endif">
                            <span class="w-1/5">
                                <img src="/{{ 'storage/'. $order->product->picture }}" class="w-24 object-cover m-auto" alt="">
                            </span>
                            <span class="w-2/5">{{ $order->product->name }}</span>
                            <span class="w-1/5">{{ $order->qty }}</span>
                            <span class="w-1/5">{{ formatRupiah($order->product->price * $order->qty) }}</span>
                        </div>
                        @empty
                            Data kosong!
                        @endforelse

                        <div class="w-full flex justify-evenly border-b-2 space-x-4">
                            <span class="w-1/5 text-white">Gambar</span>
                            <span class="w-2/5 text-white">Nama Menu</span>
                            <span class="w-1/5 font-bold">Total</span>
                            <span class="w-1/5 font-bold">{{ formatRupiah($modalData['total']) }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </x-modal.card>
    </div>
</div>

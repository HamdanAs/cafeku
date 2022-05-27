<div class="p-4">
    <nav class="flex mb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('cashier.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
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
                    <a href="{{ route('cashier.transaction') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Transaksi</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Proses</a>
                </div>
            </li>
        </ol>
    </nav>

    <h5 class="text-xl font-bold leading-none text-gray-900 mb-4 dark:text-white">Proses Transaksi</h5>

    <div class="grid grid-cols-1 gap-4">
        <div class="bg-white rounded-lg border shadow-md p-4">
            <form wire:submit.prevent="submit">
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="form.table" wire:model.lazy="form.customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    <label for="floating_email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Pelanggan</label>
                    @error('form.customer')
                    <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="form.payment" wire:model.lazy="form.payment" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    <label for="floating_email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Bayar</label>
                    @error('form.payment')
                    <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between border-b-2 pb-2 items-center">
                    <h5 class="">Detail Pemesanan</h5>
                    <input type="submit" class="flex ml-auto mt-1 px-6 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Proses" />
                </div>

                <div class="w-full flex justify-evenly mb-2 border-b-2 space-x-4">
                    <span class="w-1/5">Gambar</span>
                    <span class="w-2/5">Nama Menu</span>
                    <span class="w-1/5">Qty</span>
                    <span class="w-1/5">Subtotal</span>
                </div>

                @foreach ($items as $item)
                <div class="w-full flex justify-evenly mb-2 space-x-4 items-center @if ($loop->last)
                    border-b-2 pb-2
                @endif">
                    <span class="w-1/5">
                        <img src="/{{ 'storage/'. $item->associatedModel->picture }}" class="h-24 object-cover m-auto" alt="">
                    </span>
                    <span class="w-2/5">{{ $item->name }}</span>
                    <span class="w-1/5">{{ $item->quantity }}</span>

                    @php
                    $subtotal = "Rp " . number_format($item->price * $item->quantity,2,',','.');
                    @endphp

                    <span class="w-1/5">{{ $subtotal }}</span>
                </div>
                @endforeach

                <div class="w-full flex justify-evenly border-b-2 space-x-4">
                    <span class="w-1/5 text-white">Gambar</span>
                    <span class="w-2/5 text-white">Nama Menu</span>
                    <span class="w-1/5 font-bold">Total</span>

                    @php
                    $total = "Rp " . number_format($total,2,',','.');
                    @endphp

                    <span class="w-1/5 font-bold">{{ $total }}</span>
                </div>
            </form>
        </div>
    </div>
</div>

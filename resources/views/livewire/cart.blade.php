<ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-gray-300 flex justify-between">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Cart</h5>
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $items->count() }}</h5>
    </li>

    @forelse ($items as $item)
    <li class="w-full pl-4 pr-2 py-2 border-b border-gray-200 dark:border-gray-600 flex space-x-2">
        <div class="w-11/12">
            <span class="flex justify-between">
                <span>{{ $item->name }}</span>
                <span class="grid grid-cols-3 gap-2">
                    <button type="button" wire:click="removeQty({{ $item->id }})" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-1 py-1 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 grid place-items-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <span class="text-center py-1">{{ $item->quantity }}</span>
                    <button type="button" wire:click="addQty({{ $item->id }})" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-1 py-1 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 grid place-items-center place-self-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </span>
            </span>
            <hr class="my-1">
            <span class="flex justify-between text-gray-400">
                <span>Subtotal</span>
                <span>{{ formatRupiah($item->price * $item->quantity) }}</span>
            </span>
        </div>

        <button wire:click="deleteItem({{ $item->id }})" type="button" class="flex ml-auto">
            <svg class="w-5 h-5 hover:stroke-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </li>
    @empty
    <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">
        Keranjang masih kosong.
    </li>
    @endforelse

    @if ($items)
    <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">
        <span class="flex justify-between ">
            <span class="font-bold tracking-tight text-gray-900">Total</span>
            <span class="font-bold tracking-tight text-gray-900">{{ formatRupiah($total) }}</span>
        </span>

        <form wire:submit.prevent="process">
            <input type="submit" class="flex ml-auto mt-1 px-6 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Proses" />
        </form>
    </li>
    @endif
</ul>

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
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Menu</a>
                </div>
            </li>
        </ol>
    </nav>

    <h5 class="text-xl font-bold leading-none text-gray-900 mb-4 dark:text-white">Menu</h5>

    <div class="grid grid-cols-1 gap-4">
        <div class="bg-white rounded-lg border shadow-md p-4">
            <a href="{{ route('manager.menu.add') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Tambah Menu
                <ion-icon name="add-outline" class="ml-2 -mr-1 w-4 h-4"></ion-icon>
            </a>
            <div class="grid grid-cols-3 gap-4 mt-4">

                @foreach ($menus as $menu)
                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg h-48 w-full object-cover" src="/{{ 'storage/' . $menu?->picture }}" alt="">
                    </a>
                    <div class="p-5">
                        <div class="flex justify-between mb-4">
                            <div>
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $menu->name }}</h5>
                                <span class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                    @php
                                    $rupiah = "Rp. " . number_format($menu->price, 2, ',' ,'.')
                                    @endphp

                                    {{ $rupiah }}
                                </span>
                            </div>

                            <span class="text-sm font-medium text-gray-600 inline-flex flex-col">
                                <span class="text-center">Stock</span>

                                <span>
                                    <span class="cursor-pointer bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900" wire:click="$emit('stockSub', {{ $menu->id }})">-</span>
                                    <span>{{ $menu->stock }}</span>
                                    <span class="cursor-pointer bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900" wire:click="$emit('stockAdd', {{ $menu->id }})">+</span>
                                </span>
                            </span>
                        </div>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $menu?->description }}</p>
                        <a href="/manager/menu/edit/{{ $menu->id }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Edit
                        </a>
                        <button wire:click="deleteMenu({{ $menu->id }})" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

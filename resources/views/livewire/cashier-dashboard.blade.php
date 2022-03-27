<div class="p-4 grid grid-cols-1 gap-4">
    <div class="bg-white rounded-lg border shadow-md p-4">
        <div class="grid grid-cols-3 gap-3">
            <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center py-10">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesCount }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan</span>
                </div>
            </div>
            <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center py-10">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $salesCountToday }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan Hari Ini</span>
                </div>
            </div>
        </div>
    </div>
</div>

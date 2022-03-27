<div class="p-4 grid grid-cols-3 gap-4">
    <div class="col-span-2 bg-white rounded-lg border shadow-md p-4">
        <h5 class="text-xl font-bold leading-none text-gray-900 mb-4 dark:text-white">Log Aktifitas</h5>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                            Model Terkait
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
                            {{ $activity->subject?->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $activity->created_at }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">User Terbaru</h5>
            <a href="{{ route('admin.user') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                Lihat semua
            </a>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($users as $user)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="{{ $user->person->picture ?? asset('image/user.png') }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $user->username }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ $user->email }}
                            </p>
                        </div>
                        <!-- <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $320
                        </div> -->
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        <img src="{{ asset('image/icon.png') }}" class="mr-3 h-6 sm:h-10" alt="Flowbite Logo">
    </div>

    <div class="w-1/3 p-6 bg-white rounded-md mt-2">
        <x-errors class="mb-3" />
        <form wire:submit.prevent="login">
            <x-input wire:model.lazy="form.email" class="mb-3" icon="user" label="Name" placeholder="your name" />

            <x-input wire:model.lazy="form.password" class="mb-3" icon="key" label="Password" type="password" />

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <div wire:loading.inline>Loading ... </div>
                <span wire:loading.remove>Login</span>
            </button>

            <x-button href="/register" label="Register" outline primary />
        </form>
        <x-dialog z-index="z-50" blur="md" align="center" />
    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 dark:text-gray-500 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div style="height: 450px" class="py-12 container d-flex align-items-center justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-500 dark:text-gray-500">
                    <a href="{{ route('files.create') }}" @class(['hover:text-gray-400'])>Upload File</a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-500 dark:text-gray-500">
                    <a href="{{ route('files.index') }}" @class(['hover:text-gray-400'])>Your Files</a>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                &copy{!! date('Y') . '<strong class="text-green-600">Mansour Al-Dadah</strong>' !!}
            </h2>
        </x-slot>
    </div>
</x-app-layout>

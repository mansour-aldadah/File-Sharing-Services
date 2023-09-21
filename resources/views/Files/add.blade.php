<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ url('/') }}" class="hover:text-gray-400">{{ __('Dashboard') }}</a>
        </h2>
    </x-slot>

    <x-alert />
    <div class="py-12 d-flex justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="col-md-12 d-flex justify-content-center">
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('files.store') }}" class="form" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('files._form', ['btnName' => 'Upload'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

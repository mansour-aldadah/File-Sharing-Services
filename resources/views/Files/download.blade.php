<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ url('/') }}" class="hover:text-gray-400">{{ __('Dashboard') }}</a>
        </h2>
    </x-slot>

    <x-alert message="error" class="alert alert-danger" />
    <div class="py-12 d-flex justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="col-md-12 d-flex justify-content-center">
                <img src="{{ asset('download.png') }}" alt="upload" @class(['img-fluid w-20 rounded-5'])>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mx-1 card">
                        <div class="card-body">
                            <label class="col-form-label mb-2 d-block">Title: <strong
                                    class="text-info">{{ $file->title }}</strong></label>
                            <label class="col-form-label mb-2 d-block">Description:{{ $file->description }}</label>

                            <a href="{{ route('files.show-file', [$file->code, $file->file]) }}" target="_blank">
                                <x-primary-button @class(['w-100 justify-content-center text-center'])>Show</x-primary-button> </a>
                            <div class="d-flex justify-between m-3">
                                <a href="{{ $link }}"><x-secondary-button>Download</x-secondary-button></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

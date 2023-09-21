<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ url('/') }}" class="hover:text-gray-400">{{ __('Dashboard') }}</a>
        </h2>
    </x-slot>
    <x-alert />
    <x-alert message="error" @class(['alert alert-danger mt-5']) />
    <div class="container" style="margin-right:130px;margin-left:130px">
        <div class="py-12 row">
            @forelse($files as $file)
                @if($file->user_id == $user)
                    <div class="mx-1 card col-md-3">
                        <div class="card-body">
                            <label class="col-form-label mb-2 ml-2 mr-2 d-block">Title: <strong class="text-info">{{ $file->title }}</strong></label>
                            @if ($file->description)
                            <label class="col-form-label ml-2 mr-2 mb-2 d-block">Description: <strong class="text-info">{{ $file->description }}</strong></label>
                            @endif
                            <label class="col-form-label ml-2 mr-2 mb-2 d-block">file name: <strong class="text-info">{{ $file->file }}</strong></label>

                            <label class="col-form-label ml-2 mr-2 mb-2 d-block">Upload Time: <strong class="text-info">{{ $file->created_at->format('d/m/Y') }}</strong></label>
                            <label class="col-form-label ml-2 mr-2 mb-2 d-block">Shared Url: <strong class="text-info" id="link-{{ $file->id }}">
                                    <x-text-input value="{{ $file->downloadLink }}" disabled />
                                </strong></label>

                            <div class="d-flex justify-between ml-2 mr-2">
                                <x-primary-button style="width:150px; justify-content:center" data-url="{{ route('files.show-file', [$file->code, $file->file]) }}" class="showButton">Show</x-primary-button>
                                <a href="{{ route('files.edit', $file->id) }}"><x-secondary-button style="width:150px; justify-content:center">Edit</x-secondary-button></a>
                            </div>
                            <form action="{{ route('files.destroy', $file->id) }}" method="post" @class(['m-2'])>
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="w-100 text-center justify-content-center">Delete</x-danger-button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @empty
                    <h3 class="text-center text-info">YOU DON'T HAVE ENY FILE UPLOADED.</h3>
            @endforelse
        </div>
    </div>

    @push('extra-js')
    <script>
        $(document).ready(function() {

            $('.showButton').click(function() {
                window.open($(this).data('url'), '_blank');
            });

            // $('.copyButton').click(function () {
            //     navigator.clipboard.writeText('textToCopy').then(
            //         function () {
            //             /* clipboard successfully set */
            //             window.alert('Success! The text was copied to your clipboard')
            //         },
            //         function () {
            //             /* clipboard write failed */
            //             window.alert('Opps! Your browser does not support the Clipboard API')
            //         }
            //     )
            //     // // Select the text content of the element
            //     // $id = $(this).data('id');
            //     // var textToCopy = document.getElementById('#link-' + $id)
            //     // var range = document.createRange();
            //     // range.selectNode(textToCopy);
            //     // window.getSelection().removeAllRanges();
            //     // window.getSelection().addRange(range);
            //     //
            //     // // Copy the selected text to the clipboard
            //     // document.execCommand('copy');
            //     //
            //     // // Clean up by deselecting the text
            //     // window.getSelection().removeAllRanges();
            //     //
            //     // // Optionally, display a message to indicate that the text has been copied
            //     // alert('Data copied to clipboard: ' + textToCopy.textContent);
            // });
        });
    </script>
    @endpush
</x-app-layout>
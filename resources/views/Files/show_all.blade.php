<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Scripts -->

    <style>
        footer {
            position: relative;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <x-alert />
    <x-alert message="error" @class(['alert alert-danger mt-5']) />
    <div class="container" style="margin-right:130px;margin-left:130px">
        <div class="py-12 row">
            @forelse($files as $file)
            <div class="mx-1 card col-md-3">
                <div class="card-body">
                    <label class="col-form-label mb-2 ml-2 mr-2 d-block">Title: <strong class="text-info">{{ $file->title }}</strong></label>
                    @if ($file->description)
                    <label class="col-form-label ml-2 mr-2 mb-2 d-block">Description: <strong class="text-info">{{ $file->description }}</strong></label>
                    @endif
                    <label class="col-form-label ml-2 mr-2 mb-2 d-block">Upload Time: <strong class="text-info">{{ $file->created_at->format('d/m/Y') }}</strong></label>
                    <label class="col-form-label ml-2 mr-2 mb-2 d-block">Shared Url: <strong class="text-info" id="link-{{ $file->id }}">
                            <x-text-input value="{{ $file->downloadLink }}" disabled />
                        </strong></label>

                    <label class="col-form-label ml-2 mr-2 mb-2 d-block">Views : <strong class="text-info">{{ $file->download_counters  }}</strong></label>
                    
                    <div class="d-flex justify-between ml-2 mr-2">
                        <a target="_blank" href="{{ route('files.show_file', [$file, ]) }}"><x-primary-button style="width:100%; justify-content:center">View & Download</x-primary-button></a>
                    </div>

                </div>
            </div>

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

</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/picker.min.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/picker.min.js') }}"></script>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/input_post.js') }}" defer></script>
        <script src="{{ asset('js/handleUI.js') }}" defer></script>
        <script src="{{ asset('js/toast.js') }}"></script>
        <script src="{{ asset('js/handleLike.js') }}"></script>
        <script src="{{ asset('js/input_comment.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow app__header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <x-modal></x-modal>
        <x-toast></x-toast>
        @if(session('message'))
            @if (session('message') == 'success destroy post')
                <script>
                    showToast('Bài viết của bạn đã được xóa')
                </script>
            @elseif (session('message') == 'success update post')
                <script>
                    showToast('Bài viết của bạn đã cập nhật thành công')
                </script>
            @elseif (session('message') == 'success create post')
                <script>
                    showToast('Bài viết của bạn đã được tạo thành công')
                </script>
            @endif
        @endif
    </body>
</html>

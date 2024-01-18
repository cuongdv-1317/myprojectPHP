@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-6 mt-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 flex mt-6">
            <div class="w-full bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex mb-4">
                        <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                        <div class="ml-1">
                            <div class="font-semibold text-xl">{{ Auth::user()->username }}</div>
                            <div class="flex items-center text-xs text-gray-600">
                            <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-xs">
                                @if ($post->status == 0)
                                    <option value='private'>Chỉ mình tôi</option>
                                    <option value='public' selected>Công khai</option>
                                @else
                                    <option value='private' selected>Chỉ mình tôi</option>
                                    <option value='public'>Công khai</option>
                                @endif
                            </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <textarea class="input__post mt-2 w-full" name="content" id="input__post-id" placeholder="Bạn đang nghĩ gì?">{{ $post->content }}</textarea>
                    <div class="flex justify-end">
                        <div class="insert__post-btn mr-3"><i class="fa-regular fa-image"></i></div>
                        <div class="insert__post-btn" onclick="showEmoji(this)"><i class="fa-solid fa-face-laugh"></i></div>
                    </div>
                    <button type="submit" class="w-full primary__btn p-2 text-center" id="create__post-btn">
                        Lưu
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

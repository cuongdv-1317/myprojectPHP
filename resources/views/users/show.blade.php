@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personal page') }}
        </h2>
    </x-slot>

    <div class="pt-8 mt-4">
        <div class="pt-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg px-6 personal__header pb-1">
                    <div class="flex personal__header-info">
                        <img class="mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                        <div class="ml-4 mb-1">
                            <div class="personal__header-name">{{ $user->username }}</div>
                            <div class= "text-gray-600">0 bạn bè</div>
                        </div>
                    </div>
                    @if ($user->id != Auth::user()->id)
                        <div class="personal__header-addfr primary__btn p-2">
                            + Thêm bạn bè
                        </div>
                    @endif
                    <hr>
                    <div class="flex my-2 personal__nav">
                        <div class="px-4 py-2 personal__nav-item">Bài viết</div>
                        <div class="px-4 py-2 personal__nav-item">Bạn bè</div>
                        <div class="px-4 py-2 personal__nav-item">Ảnh</div>
                        <div class="px-4 py-2 personal__nav-item">Video</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex mt-6 app__container">
            <div class="dashboard__left">
                @if ($user->id == Auth::user()->id)
                    <div class="bg-white shadow sm:rounded-lg p-6 mb-4">
                        <div class="flex items-center personal__page-btn p-2">
                            <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                            <a href="{{ route('posts.create') }}" class="create__post-btn px-4 py-2">Bạn đang nghĩ gì thế?</a>
                        </div>
                    </div>
                @endif
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="p-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="font-semibold text-xl">Giới thiệu</div>
                            @if ($user->id == Auth::user()->id)
                                <div class="text__btn">Chỉnh sửa</div>
                            @endif
                        </div>
                        <div class="py-2">
                            <i class="fa-solid fa-user-group mr-3 w-5"></i>
                            Có 0 bạn bè
                        </div>
                        <div class="py-2">
                            <i class="fa-solid fa-location-dot mr-3 w-5"></i>
                            Sống tại
                        </div>
                        <div class="py-2">
                            <i class="fa-solid fa-building mr-3 w-5"></i>
                            Làm việc tại
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard__right">
                @foreach ($user->posts()->orderBy('created_at', 'desc')->get() as $post)
                    @if (!(Auth::user()->id != $user->id && $post->status == 1))
                        <div class="bg-white shadow sm:rounded-lg p-6 mb-4">
                            <div class="flex justify-between items-center">
                                <div class="flex">
                                    <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                                    <div class="ml-1">
                                        <div class="font-semibold post__author">{{ $user->username }}</div>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <div class="mr-2">{{ Carbon::parse($post->created_at)->diffForHumans() }}</div>
                                            @if ($post->status == 0)
                                                <i class="fa-solid fa-earth-americas"></i>
                                            @else
                                                <i class="fa-solid fa-lock"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="post__btn-circle flex items-center justify-center mr-3">
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <i class="fa-solid fa-ellipsis text-xl"></i>
                                            </x-slot>

                                            <x-slot name="content">
                                                @if (Auth::user()->id == $post->user->id)
                                                    <x-dropdown-link :href="route('posts.edit', ['post' => $post->id])">
                                                        <i class="fa-solid fa-pen w-4 mr-2"></i>
                                                        Chỉnh sửa bài viết
                                                    </x-dropdown-link>

                                                    <x-dropdown-link
                                                        route="{{ route('posts.destroy', ['post' => $post->id]) }}"
                                                        onclick="document.getElementById('modal').classList.add('flex');
                                                                    document.getElementById('modal').classList.remove('hidden');
                                                                    document.getElementById('destroy__post-form').action = this.getAttribute('route');">
                                                        <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                        Xóa bài viết
                                                    </x-dropdown-link>
                                                @else
                                                    <x-dropdown-link>
                                                        <i class="fa-solid fa-bookmark w-4 mr-2"></i>
                                                        Lưu bài viết
                                                    </x-dropdown-link>
                                                    <x-dropdown-link>
                                                        <i class="fa-solid fa-bullhorn w-4 mr-2"></i>
                                                        Báo cáo bài viết
                                                    </x-dropdown-link>
                                                @endif
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                    <div class="post__btn-circle flex items-center justify-center ml-1">
                                        <i class="fa-solid fa-xmark text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 mb-4">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                            <div class="flex mb-4 justify-between">
                                <a href="#" class="flex like__comment">
                                    <img src="{{ asset('images/like.png') }}" alt="" class="w-6 mr-3">
                                    <div class="">
                                        {{ $post->likedUsers()->count() }}
                                    </div>
                                </a>
                                <a href="#" class="flex items-center like__comment">
                                    <div class="">
                                        300
                                    </div>
                                    <i class="fa-solid fa-comment ml-3"></i>
                                </a>
                            </div>
                            <hr>
                            <div class="mt-1 flex">
                                <form action="" method="POST" route="{{ route('likes.like', ['user' => Auth::user()->id, 'post' => $post->id]) }}" class="flex flex-1" onsubmit="submitLikeForm(event, this, this.getAttribute('route'))">
                                    @csrf
                                    @if (Auth::user()->likedPosts()->find($post->id))
                                        <button class="text-center py-2 like-btn font-semibold active">
                                            <i class="fa-regular fa-thumbs-up"></i>
                                            Thích
                                        </button>
                                    @else
                                        <button class="text-center py-2 like-btn font-semibold">
                                            <i class="fa-regular fa-thumbs-up"></i>
                                            Thích
                                        </button>
                                    @endif
                                </form>
                                <div class="text-center py-2 comment-btn font-semibold">
                                    <i class="fa-regular fa-comment"></i>
                                    Bình luận
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

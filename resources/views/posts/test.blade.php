@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-6 mt-4">
        <div class="fixed justify-center items-center flex flex-col" id="modal__post">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div class="flex">
                            <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                            <div class="ml-1">
                                <a href="{{ route('users.show', ['user' => $post->user->id]) }}" class="font-semibold post__author">{{ $post->user->username }}</a>
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
                        <a href="{{ route('comments.showCommentPost', ['post' => $post->id]) }}" class="flex items-center like__comment">
                            <div class="">
                                {{ $post->comments()->count() }}
                            </div>
                            <i class="fa-solid fa-comment ml-3"></i>
                        </a>
                    </div>
                    <hr>
                    <div class="mt-1 flex mb-1">
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
                        <a href="#" class="text-center py-2 comment-btn font-semibold" onclick="focusCommentPost(this)">
                            <i class="fa-regular fa-comment"></i>
                            Bình luận
                        </a>
                    </div>
                    <hr>
                    <div class="comments__list-post">
                        @foreach ($post->comments()->orderBy('updated_at', 'desc')->get() as $comment)
                            @if ($comment->parent_id === null)
                                <div class="mt-4">
                                    <div class="flex">
                                        <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                                        <div class="comments__body mr-3">
                                            <a href="{{ route('users.show', ['user' => $comment->user->id]) }}" class="font-semibold post__author">{{ $comment->user->username }}</a>
                                            <div class="">{{ $comment->content }}</div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="post__btn-circle flex items-center justify-center mr-3" onclick="showDropDownMenuComment(this)">
                                                <i class="fa-solid fa-ellipsis text-xl"></i>
                                                @if (Auth::user()->id == $comment->user->id)
                                                    <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                        <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" onclick="showEditComment(this)">
                                                            <i class="fa-solid fa-pen w-4 mr-2"></i>
                                                            Chỉnh sửa
                                                        </div>
                                                        <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                            <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                            Xóa
                                                        </div>
                                                    </div>
                                                @else
                                                    @if (Auth::user()->id == $post->user->id)
                                                        <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                            <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                <i class="fa-solid fa-eye-slash w-4 mr-2"></i>
                                                                Ẩn
                                                            </div>
                                                            <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                                Xóa
                                                            </div>
                                                            <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                <i class="fa-solid fa-circle-exclamation w-4 mr-2"></i>
                                                                Báo cáo bình luận
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                            <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                <i class="fa-solid fa-eye-slash w-4 mr-2"></i>
                                                                Ẩn
                                                            </div>
                                                            <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                <i class="fa-solid fa-circle-exclamation w-4 mr-2"></i>
                                                                Báo cáo bình luận
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex comment__info mt-1 text-sm text-gray-600">
                                        <div class="mr-3">{{ Carbon::parse($comment->created_at)->diffForHumans() }}</div>
                                        <a href="#" class="mr-3 font-semibold">Thích</a>
                                        <a href="#" class="mr-3 font-semibold" onclick="focusCommentReply(this)">Phản hồi</a>
                                    </div>
                                    @foreach ($comment->replies()->orderBy('updated_at', 'asc')->get() as $commentReply)
                                        <div class="mt-2 comment__child">
                                            <div class="flex">
                                                <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                                                <div class="comments__body mr-3">
                                                    <a href="{{ route('users.show', ['user' => $commentReply->user->id]) }}" class="font-semibold post__author">{{ $commentReply->user->username }}</a>
                                                    <div class="">{{ $commentReply->content }}</div>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="post__btn-circle flex items-center justify-center mr-3" onclick="showDropDownMenuComment(this)">
                                                        <i class="fa-solid fa-ellipsis text-xl"></i>
                                                        @if (Auth::user()->id == $commentReply->user->id)
                                                            <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                                <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" onclick="showEditComment(this)">
                                                                    <i class="fa-solid fa-pen w-4 mr-2"></i>
                                                                    Chỉnh sửa
                                                                </div>
                                                                <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                    <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                                    Xóa
                                                                </div>
                                                            </div>
                                                        @else
                                                            @if (Auth::user()->id == $post->user->id)
                                                                <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                        <i class="fa-solid fa-pen w-4 mr-2"></i>
                                                                        Ẩn
                                                                    </div>
                                                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                        <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                                        Xóa
                                                                    </div>
                                                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                        <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                                        Báo cáo bình luận
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                        <i class="fa-solid fa-pen w-4 mr-2"></i>
                                                                        Ẩn
                                                                    </div>
                                                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                                        <i class="fa-solid fa-trash w-4 mr-2"></i>
                                                                        Báo cáo bình luận
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex comment__info mt-1 text-sm text-gray-600">
                                                <div class="mr-3">{{ Carbon::parse($commentReply->created_at)->diffForHumans() }}</div>
                                                <div class="mr-3 font-semibold">Thích</div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="flex comment__child mt-2">
                                        <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                                        <form action="" method="POST" class="flex items-center input__comment" route="{{ route('comments.store') }}" onsubmit="submitComment(event, this, this.getAttribute('route'))">
                                            @csrf
                                            <input type="text" name="content" placeholder="Viết phản hồi..." oninput="checkInputEmpty(this, event)" autocomplete="off">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <button type="submit" disabled="disabled">
                                                <i class="fa-solid fa-paper-plane ml-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex p-6 py-4">
                    <img class="dashboard__image mr-3" src="{{ asset('images/default_avatar.png') }}" alt="">
                    <form action="" method="POST" class="flex items-center input__comment" route="{{ route('comments.store') }}" onsubmit="submitComment(event, this, this.getAttribute('route'))">
                        @csrf
                        <input type="text" name="content" placeholder="Viết bình luận..." oninput="checkInputEmpty(this, event)" autocomplete="off">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="">
                        <button type="submit" disabled="disabled">
                            <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@if (isset($message) && $message == 'success destroy post')
    <script src="{{ asset('js/toast.js') }}"></script>
    <script>
        showToast('Bài viết của bạn đã được xóa')
    </script>
@endif

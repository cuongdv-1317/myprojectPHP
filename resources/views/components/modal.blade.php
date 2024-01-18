<div class="fixed justify-center items-center hidden" id="modal">
    <div class="bg-white rounded-lg py-4">
        <h2 class="text-xl pb-3 font-semibold text-center">Xóa bài viết?</h2>
        <hr>
        <p class="px-6 mt-4 mb-4">Bài viết của bạn sẽ bị xóa.</p>
        <hr>

        <div class="flex">
            <form method="POST" action="" id="destroy__post-form" class="flex justify-center">
                @csrf
                @method('DELETE')
                <button
                    class="py-2 rounded"
                    onclick="document.getElementById('modal').classList.add('hidden');
                                document.getElementById('modal').classList.remove('flex')"
                >
                    Confirm
                </button>
            </form>

            <button
                class="py-2 rounded"
                onclick="document.getElementById('modal').classList.add('hidden');
                            document.getElementById('modal').classList.remove('flex')"
            >
                Close
            </button>
        </div>
    </div>
</div>

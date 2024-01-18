function focusCommentPost(commentBtn) {
    var commentInput = commentBtn.parentNode.parentNode.parentNode.children[1].children[1].children[1]
    commentInput.focus()
    console.log(commentInput)
}

function focusCommentReply(replyComment) {
    var commentInput = replyComment.parentNode.parentNode.lastElementChild.children[1].children[1]
    commentInput.focus()
}

function checkInputEmpty(commentInput, event) {
    var submitBtn = commentInput.parentNode.children[5]
    var inputText = event.target.value;
    if (inputText === "") {
        submitBtn.disabled = true;
        submitBtn.style.color = "black"
    } else {
        submitBtn.disabled = false;
        submitBtn.style.color = "#0866ff"
    }
    console.log(inputText);
}

document.addEventListener("DOMContentLoaded", function() {
    var inputComments = document.getElementsByClassName("input__comment");
    for (var i = 0; i < inputComments.length; i++) {
        var submitBtn = inputComments[i].children[5]
        submitBtn.disabled = true;
        submitBtn.style.color = "black"
    }
});

document.addEventListener('click', function(event) {
    var dropDownMenu = document.getElementsByClassName('dropdown__menu-comment');
    for (let i = 0; i < dropDownMenu.length; i++) {
        if (dropDownMenu[i].style.display == 'block') {
            var btn = dropDownMenu[i].parentNode
            if (event.target !== btn && !btn.contains(event.target)) {
                dropDownMenu[i].style.display = 'none'
                btn.style.backgroundColor = '#fff'
            }
            break
        }
    }
});

function showDropDownMenuComment(btn) {
    var dropDownMenu = btn.children[1]
    dropDownMenu.style.display = dropDownMenu.style.display == 'block' ? 'none' : 'block'
    btn.style.backgroundColor = dropDownMenu.style.display == 'block' ? '#f0f2f5' : '#fff'
    var dropDownMenus = document.getElementsByClassName('dropdown__menu-comment');
    for (let i = 0; i < dropDownMenus.length; i++) {
        if (dropDownMenus[i] != dropDownMenu) {
            dropDownMenus[i].style.display = 'none'
            var btnElement = dropDownMenus[i].parentNode
            btnElement.style.backgroundColor = '#fff'
        }
    }
}

function submitComment(event, form, route) {
    event.preventDefault()
    var formData = new FormData(form);
    console.log(formData)
    fetch(route, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data['message']) {
            console.log(data['data'])
            if (data['data']['comment']['parent_id'] == null) {
                var commentsList = document.querySelector('.comments__list-post')
                var firstChild = commentsList.firstChild
                var newComment = document.createElement("div");
                newComment.classList.add('mt-4')
                newComment.innerHTML = `
                    <div class="mt-4">
                        <div class="flex">
                            <img class="dashboard__image mr-3" src="http://127.0.0.1:8000/images/default_avatar.png" alt="">
                            <div class="comments__body mr-3">
                                <a href="${data['data']['route']}" class="font-semibold post__author">${data['data']['user']['username']}</a>
                                <div class="">${data['data']['comment']['content']}</div>
                            </div>
                            <div class="flex items-center">
                                <div class="post__btn-circle flex items-center justify-center mr-3" onclick="showDropDownMenuComment(this)">
                                    <i class="fa-solid fa-ellipsis text-xl"></i>
                                    <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                        <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                            <i class="fa-solid fa-pen w-4 mr-2"></i>
                                            Chỉnh sửa
                                        </div>
                                        <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                            <i class="fa-solid fa-trash w-4 mr-2"></i>
                                            Xóa
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex comment__info mt-1 text-sm text-gray-600">
                            <div class="mr-3">${data['data']['created_at']}</div>
                            <div class="mr-3 font-semibold">Thích</div>
                            <div class="mr-3 font-semibold">Phản hồi</div>
                        </div>
                        <div class="flex comment__child mt-2">
                            <img class="dashboard__image mr-3" src="http://127.0.0.1:8000/images/default_avatar.png" alt="">
                            <form action="" method="POST" class="flex items-center input__comment" route="{{ route('comments.store') }}" onsubmit="submitComment(event, this, this.getAttribute('route'))">
                                <input type="hidden" name="_token" value="${formData.get('_token')}">
                                <input type="text" name="content" placeholder="Viết phản hồi..." oninput="checkInputEmpty(this, event)" autocomplete="off">
                                <input type="hidden" name="user_id" value="${data['data']['user']['id']}">
                                <input type="hidden" name="post_id" value="${data['data']['post']['id']}">
                                <input type="hidden" name="parent_id" value="${data['data']['comment']['id']}">
                                <button type="submit" disabled="disabled">
                                    <i class="fa-solid fa-paper-plane ml-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                `
                commentsList.insertBefore(newComment, firstChild)
                var numbCommentEle = document.getElementsByClassName('like__comment')[1].children[0]
                var newNumbComment = parseInt(numbCommentEle.innerHTML) + 1
                console.log(numbCommentEle)
                console.log(newNumbComment)
                numbCommentEle.innerHTML = newNumbComment
            } else {
                var commentsList = form.parentNode.parentNode
                var lastChild = form.parentNode
                var newComment = document.createElement("div");
                newComment.classList.add('mt-2')
                newComment.classList.add('comment__child')
                newComment.innerHTML = `
                    <div class="flex">
                        <img class="dashboard__image mr-3" src="http://127.0.0.1:8000/images/default_avatar.png" alt="">
                        <div class="comments__body mr-3">
                            <a href="${data['data']['route']}" class="font-semibold post__author">${data['data']['user']['username']}</a>
                            <div class="">${data['data']['comment']['content']}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="post__btn-circle flex items-center justify-center mr-3" onclick="showDropDownMenuComment(this)">
                                <i class="fa-solid fa-ellipsis text-xl"></i>
                                <div class="dropdown__menu-comment bg-white shadow-lg sm:rounded-lg">
                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        <i class="fa-solid fa-pen w-4 mr-2"></i>
                                        Chỉnh sửa
                                    </div>
                                    <div class="flex items-center px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        <i class="fa-solid fa-trash w-4 mr-2"></i>
                                        Xóa
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex comment__info mt-1 text-sm text-gray-600">
                        <div class="mr-3">${data['data']['created_at']}</div>
                        <div class="mr-3 font-semibold">Thích</div>
                    </div>
                `
                commentsList.insertBefore(newComment, lastChild)
                var numbCommentEle = document.getElementsByClassName('like__comment')[1].children[0]
                var newNumbComment = parseInt(numbCommentEle.innerHTML) + 1
                console.log(numbCommentEle)
                console.log(newNumbComment)
                numbCommentEle.innerHTML = newNumbComment
            }
        }
    })
    .catch(error => {
        console.error('Error', error);
    });
    var submitBtn = form.children[5]
    var inputComment = form.children[1]
    inputComment.value = ""
    submitBtn.disabled = true;
    submitBtn.style.color = "black"
}

function showEditComment(editBtn) {
    var commentBody = editBtn.parentNode.parentNode.parentNode.parentNode
    var commentContent = commentBody.children[1].children[1].innerHTML
    var form = document.createElement('div')
    form.innerHTML = `
        <form action="" method="POST" class="flex items-center input__comment" route="{{ route('comments.store') }}" onsubmit="submitComment(event, this, this.getAttribute('route'))">
            @csrf
            <input type="text" name="content" oninput="checkInputEmpty(this, event)" value="${commentContent}">
            <input type="hidden" name="id" value="1">
            <button type="submit" disabled="disabled">
                <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
        </form>
    `
    commentBody.insertBefore(form, commentBody.children[2])
    commentBody.removeChild(commentBody.children[1])
    console.log(commentBody)
    console.log(commentContent)
}

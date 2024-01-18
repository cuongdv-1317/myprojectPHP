function showToast(msg) {
    var toast = document.getElementById('toast')
    var toastContent = document.querySelector('.toast__content')
    toastContent.innerHTML = msg
    toast.classList.remove('hidden')
    setTimeout(function() {
        toast.classList.add('hidden')
    }, 4000)
}

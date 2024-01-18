function submitLikeForm(event, form, route) {
    event.preventDefault()
    var num_like_ele = form.parentNode.parentNode.children[2].children[0].children[1]
    var numb_like = parseInt(num_like_ele.innerHTML)
    var btn = form.children[1]
    if (btn.classList.contains('active')) {
        var formData = new FormData(form); // Lấy dữ liệu form
        formData.append('_method', 'DELETE'); // Thêm trường _method với giá trị DELETE
        fetch(route, {
            method: 'POST',
            body: formData
        })
        numb_like -= 1
        btn.classList.remove('active');
    } else {
        var formData = new FormData(form);
        fetch(route, {
            method: 'POST',
            body: formData
        })
        numb_like += 1
        btn.classList.add('active');
    }
    num_like_ele.innerHTML = numb_like
}

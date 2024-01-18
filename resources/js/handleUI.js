var nav = document.querySelector('.app__nav')
var header = document.querySelector('.app__header')
var container = document.querySelector('.app__container')
var personalHeader = document.querySelector('.personal__header')

if (personalHeader == null) {
    container.style.height = `calc(100vh - ${nav.clientHeight}px - ${header.clientHeight}px - 2rem)`
} else {
    container.style.height = `calc(100vh - ${nav.clientHeight}px - ${header.clientHeight}px - 5rem)`
}

window.addEventListener('resize', function() {
    if (personalHeader == null) {
        container.style.height = `calc(100vh - ${nav.clientHeight}px - ${header.clientHeight}px - 2rem)`
    } else {
        container.style.height = `calc(100vh - ${nav.clientHeight}px - ${header.clientHeight}px - 5rem)`
    }
});

// var contents = document.querySelectorAll('.post__content');
// for (let i = 0; i < contents.length; i++) {
//     var lineHeight = parseInt(window.getComputedStyle(contents[i]).lineHeight);
//     var contentHeight = contents[i].clientHeight
//     var numberOfLines = contentHeight / lineHeight;
//     if (numberOfLines > 10) {
//         contents[i].style.height = `calc(10 * ${lineHeight}px)`
//         contents[i].style.overflowY = 'hidden'
//     }
//     console.log('Số dòng được hiển thị:', numberOfLines);
// }

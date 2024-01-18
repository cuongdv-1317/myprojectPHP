var btnCreate = document.getElementById('create__post-btn')
var inputPost = document.getElementById('input__post-id')
if (inputPost.value === "") {
    btnCreate.disabled = true;
    btnCreate.classList.add('unclickable')
}
inputPost.addEventListener('input', function(event) {
    var inputText = event.target.value;
    if (inputText === "") {
        btnCreate.disabled = true;
        btnCreate.classList.add('unclickable')
    } else {
        btnCreate.disabled = false;
        btnCreate.classList.remove('unclickable')
    }
    console.log(inputText);
})

// const emojiPickerButton = document.getElementById('emojiPickerButton');

// const emojiPicker = new Picker(emojiPickerInput, {
//     format: 'emoji',
// });

// emojiPickerButton.addEventListener('click', function() {
//     emojiPicker.open();
// });

// emojiPicker.on('emoji', function(emoji) {
//     emojiPickerInput.value = emoji.emoji;
//     emojiPicker.close();
// });

function showEmoji(btn) {
    // var emojiButton = document.getElementById('emojiButton');
    var picker = new Picker({
        container: btn,
        onSelect: function (emoji) {
            // Get the selected emoji and insert it into the textarea
            // var selectedEmoji = emoji.native;
            // var textarea = document.getElementById('selectedEmoji');
            // textarea.value += selectedEmoji;
        }
    });

    // Open the picker when the button is clicked
    picker.showPicker();
}

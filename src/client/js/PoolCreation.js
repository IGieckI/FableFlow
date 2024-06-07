function loadPoolCreation() {


    document.getElementById('add_option').setAttribute('listening', 'false');

    document.getElementById('text_option').addEventListener('input', () => {
        let text = $('#text_option');
        let add = $('#add_option');
        if (text.val().length == 0) {
            resetInput();
        } else {
            add.removeAttr("style");
            if (add.attr('listening') == 'false') {
                add.attr('listening', 'true');
                add.on('click', function(ev) {
                    confirmOption();
                    ev.stopPropagation();
                    resetInput();
                });
            }
        }
    });
}

function resetInput() {
    let text = $('#text_option');
    let add = $('#add_option');
    add.attr("style", "display: none;");
    text.val("");
    text.addClass('empty-option');
    add.attr('listening', 'false')
    add.off('click');
}

function confirmOption() {
    let li = document.createElement('li');
    let text = document.createElement('span');
    let trash = document.createElement('i');
    li.className = 'confirmed-option';
    text.innerText = $('#text_option').val();
    li.appendChild(text);
    trash.className = "bi bi-trash";
    li.appendChild(trash);
    document.getElementById('choices_list').insertBefore(li, document.getElementById('input_pool'));
}
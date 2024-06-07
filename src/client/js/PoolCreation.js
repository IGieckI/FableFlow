function loadPoolCreation(chapterId) {

    document.querySelector('#pool-creation-form').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          // do nothing
        }
    });
    $("#expiration_datetime").datepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss"
    });

    document.getElementById('clearButton').addEventListener('click', function() {
        $('#title').val("");
        $('#text').val("");
        $('#expiration_datetime').val("");
        document.querySelectorAll('.confirmed-option').forEach(function(el) {
            el.remove();
        });
    });

    $('#pool-creation-form').submit(function(e) {
        e.preventDefault();    
        $.ajax({
            url: '/FableFlow/src/server/api/AddPool.php',
            method: 'POST',
            data: {
                title: $('#title').val(), 
                content: $('#text').val(), 
                choices: Array.from(document.querySelectorAll('.confirmed-option')).map((el)=>el.innerText),
                chapterId: chapterId,
                expire_datetime: $('#expiration_datetime').val()
            },
            success: function(){
                loadContent('pools', function(){
                    initializePoolOverview(chapterId);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error adding pool:', textStatus, errorThrown);
                console.log(jqXHR.responseText);
            }
        });
        
    });

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
    trash.className = "delete bi bi-trash";
    trash.addEventListener('click', function() {
        trash.parentNode.remove();
    })
    li.appendChild(trash);
    document.getElementById('choices_list').insertBefore(li, document.getElementById('input_pool'));
}
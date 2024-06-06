$(document).ready(function() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetOwnerStories.php', // Sostituisci con il percorso corretto al tuo file PHP
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            function firstTwoLetters(stringa) {
                return stringa.substring(0, 2);
            }

            const titles = Object.keys($title);
            const select = document.getElementById("story_title");
            let row = "";
            for(let i = 0; i < $title.length; i++){
                row += '<option value="${firstTwoLetters(titles[i])}">${titles[i]}</option>';
            }
            select.innerHTML +=row;
        },
        error: function(xhr, status, error) {
            console.error('Si è verificato un errore durante la richiesta:', error);
        }
    });
});
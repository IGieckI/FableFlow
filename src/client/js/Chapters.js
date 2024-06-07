$(document).ready(function() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetOwnerStories.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            
            const titles = response["titles"];

            //const titles = Object.keys($title);
            const select = document.getElementById("story-title");
            
            let row = "";
            for(let i = 0; i < titles.length; i++){
                row += "<option value=\"" + titles[i] + "\">" + titles[i] + "</option>";
            }
            select.innerHTML +=row;
        },
        error: function(xhr, status, error) {
            console.error('Si è verificato un errore durante la richiesta:', error);
        }
    });
});
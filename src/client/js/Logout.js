$(document).ready(function() {
    $("#logout").click(function() {
        $.ajax({
            url: "/FableFlow/src/server/api/Logout.php",
            type: "DELETE",
            success: function(response) {
                window.location.href = '/FableFlow/src/client/Login.php';
            },
            error: function(xhr, status, error) {
                console.error('Errore durante il logout:', error);
                alert('Errore durante il logout. Riprova.');
            }
        });
    });
});
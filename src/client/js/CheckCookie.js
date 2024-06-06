function checkRememberToken() {
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/CheckCookie.php",
        dataType: "json",
        success: function(response) {
            if (response.success) {
                window.location.href = "CheckCookie.php?risultato=" + response;
            }
        },
        error: function(xhr, status, error) {
            console.error("Errore nella chiamata AJAX:", error);
        }
    });
}

checkRememberToken();
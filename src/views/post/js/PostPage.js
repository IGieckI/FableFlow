//Automatically load the content of the story
document.addEventListener('DOMContentLoaded', function() {
    var currentURL = window.location.href;
    param = currentURL.split("?");
    param = param[param.length - 1].split("=");
    id = param[param.length - 1];
    loadContent('story', id);
});


// Use jQuery to load content based on the selected subpage
function loadContent(subpage, chapter_id) {
    $.ajax({
        type: "GET",
        url: "SubPostPage.php",
        data: { subpage: subpage , chapter_id: chapter_id},
        success: function(response) {
            $("#subpageContent").html(response);
        },
        error: function() {
            alert("Error loading content.");
        }
    });
}
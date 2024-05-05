//Automatically load the content of the story
document.addEventListener('DOMContentLoaded', function() {
    var currentURL = window.location.href;    
    loadContent('story', getPostId(currentURL));
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

// Get the id of the post from the URL
function getPostId(currentURL) {
    param = currentURL.split("?");
    param = param[param.length - 1].split("=");
    return param[param.length - 1];
}
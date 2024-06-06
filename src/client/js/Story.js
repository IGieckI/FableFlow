function initializeStory() {
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetStory.php",
        data: { chapterId: getChapterId(window.location.href) },
        success: function(response) {
            document.getElementById("story-content").innerHTML = response;
        },
        error: function(error) {
            console.log("Error loading page content: " + error);
        }
    });


    storyContent = document.getElementById('story-content');
    storyContent.innerHTML = storyContent.innerHTML;
}
function initializeStory() {
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetChapter.php",
        data: { chapterId: getChapterId(window.location.href) },
        success: function(response) {
            response = response[0];
            console.log(response);
            document.getElementById("story-content-span").innerHTML = response["post_content"];

            // Include the image if present
            imgElem = document.getElementById("story-img");
            console.log(imgElem);
            if (response["picture"]) {
                imgElem.setAttribute("src", getChapterImagePath(response["picture"]));
            } else {
                imgElem.setAttribute("hidden");
            }
        },
        error: function(error) {
            console.log("Error loading page content: " + error);
        }
    });
}
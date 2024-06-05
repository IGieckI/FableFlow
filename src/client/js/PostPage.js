//Automatically load the content of the story
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector("#user_icon").onclick = goToProfile;
    
    addClickListener('load-story-button', function(chapterId) {
        loadContent('story', chapterId);
    });
    
    addClickListener('load-pools-button', function(chapterId) {
        loadContent('pools', chapterId);
    });
    
    addClickListener('load-proposals-button', function(chapterId) {
        loadContent('proposals', chapterId);
        initializeProposals();
    });
    
    addClickListener('load-comments-button', function(chapterId) {
        loadContent('comments', chapterId);
        initializeComments();
    });

    addClickListener('like-icon', function(chapterId) {
        updateChapterLike(chapterId);
    });

    // Initialize the sub-page content
    $chapterId = getChapterId(window.location.href);
    loadContent('story', $chapterId);

    // Initialize the page content
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetChapter.php",
        data: { chapterId: $chapterId },
        success: function(response) {
            response = response[0];
            
            document.getElementById("chapter-title").innerHTML = response["post_title"];
            document.getElementById("like-icon").innerHTML = response["num_likes"];
            document.getElementById("like-icon").className = response["liked"] == 0 ? "bi bi-fire" : "bi bi-fire like-clicked";
            document.getElementById("user_icon").username = response["username"];
            document.getElementById("username-span").innerHTML = response["username"];
            document.getElementById("user_icon_img").src = response["user_icon"];
        },
        error: function() {
            alert("Error loading page content.");
        }
    });
});

// Add an onclick-event listener to an HTML element
function addClickListener(elementId, callback) {
    var element = document.getElementById(elementId);
    const chapterId = getChapterId(window.location.href);
    
    if (element) {
        element.addEventListener('click', function() {
            callback(chapterId);
        });
    } else {
        console.error('Button not found:', elementId);
    }
}

function loadContent(subpage, chapter_id) {
    $.ajax({
        type: "GET",
        url: "SubPostPage.php",
        data: { subpage: subpage , chapter_id: chapter_id},
        success: function(response) {
            $("#subpageContent").html(response);
        },
        error: function() {
            alert("Error loading subpage content.");
        }
    });
}

function goToProfile() {
    let username = this.getAttribute("username");
    window.location.assign('/FableFlow/src/client/profile/Profile.php?user_viewing='+username);
}

function updateChapterLike(chapterId) {
    console.log("Updating likes for chapter: " + chapterId);
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/UpdateChapterLike.php",
        data: { chapterId: chapterId },
        success: function(response) {
            document.querySelector("#like-icon").nextSibling.textContent = response.updatedLikesCount;
        },
        error: function() {
            console.log("Error updating likes.");
        }
    });
}

// Get the id of the post from the URL
function getChapterId(currentURL) {
    param = currentURL.split("?");
    param = param[param.length - 1].split("=");
    return param[param.length - 1];
}
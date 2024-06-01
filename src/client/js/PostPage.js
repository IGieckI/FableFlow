//Automatically load the content of the story
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector("#user_icon").onclick = goToProfile;
    
    // Add event listeners for each sub-page button
    function addClickListener(buttonId, callback) {
        var button = document.getElementById(buttonId);
        
        if (button) {
            button.addEventListener('click', function() {
                var storyId = button.getAttribute('data-story-id');
                callback(storyId);
            });
        }
    }

    addClickListener('load_story_button', function(storyId) {
        loadContent('story', storyId);
    });
    
    addClickListener('load_pools_button', function(storyId) {
        loadContent('pools', storyId);
    });
    
    addClickListener('load_proposals_button', function(storyId) {
        loadContent('proposals', storyId);
    });
    
    addClickListener('load_comments_button', function(storyId) {
        loadContent('comments', storyId);
    });

    // Initialize the sub-page content
    var currentURL = window.location.href;
    loadContent('story', getPostId(currentURL));
});

function goToProfile() {
    let username = this.getAttribute("username");
    window.location.assign('/FableFlow/src/client/profile/Profile.php?user_viewing='+username);
}

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
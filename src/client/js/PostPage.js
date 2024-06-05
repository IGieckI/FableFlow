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

    // Initialize the sub-page content
    loadContent('story', getPostId(window.location.href));
});

// Add an onclick-event listener to an HTML element
function addClickListener(elementId, callback) {
    var element = document.getElementById(elementId);
    const chapterId = getPostId(window.location.href);
    
    if (element) {
        element.addEventListener('click', function() {
            callback(chapterId);
        });
    } else {
        console.error('Button not found:', elementId);
    }
}

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
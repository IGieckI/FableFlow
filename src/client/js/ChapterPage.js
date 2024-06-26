//Automatically load the content of the story
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to different elements
    document.getElementById("user_icon").addEventListener('click', function() {
        goToProfile(document.getElementById("username-span").textContent);
    });
    document.getElementById("back-history-button").addEventListener('click', function() {
        history.back();
    });
    
    addClickListener('load-story-button', function(chapterId) {
        loadContent('story', function() { 
            initializeStory();
        });
    });
    
    addClickListener('load-pools-button', function(chapterId) {
        loadContent('pools', function(){
            initializePoolOverview(chapterId);
        });
    });
    
    addClickListener('load-proposals-button', function(chapterId) {
        loadContent('proposals', function() {
            newProposalButton = document.getElementById('new-proposal-button');

            addClickListener('new-proposal-button', function(storyId) {
                loadContent('create-proposal', function() {
                    document.getElementById('hidden-chapter-id').value = getChapterId(window.location.href);
                });
            });

            initializeProposals();
        });
    });
    
    addClickListener('load-comments-button', function(chapterId) {
        loadContent('comments', function() {
            document.getElementById("send-button").addEventListener('click', function() {
                let message = $("#message-input").val();
        
                if (message.trim() !== "") {
                    $.ajax({
                        url: "/FableFlow/src/server/api/PostChapterComment.php",
                        type: "POST",
                        data: { chapterId: getChapterId(window.location.href), content: message},
                        dataType: "json",
                        success: function(response) {
                            $("#message-input").val("");
                            
                            // Clear the comments container
                            let commentsContainer = $("#comments-container");
                            commentsContainer.empty();
        
                            // Reload the comments or posts (replace this with the appropriate function)
                            loadComments();
                        },
                        error: function(error) {
                            console.error("Error loading comments:", error);
                        }
                    });
                }
            });
            
            initializeComments();
        });
    });

    addClickListener('like-icon', function(chapterId) {
        updateChapterLike(chapterId);
    });

    // Initialize the sub-page content
    loadContent('story', function() { 
        initializeStory();
    });

    // Initialize the page content
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetChapter.php",
        data: { chapterId: getChapterId(window.location.href) },
        success: function(response) {
            response = response[0];

            document.getElementById("chapter-title").innerHTML = response["post_title"] + ": " + response["story_title"];
            document.getElementById("like-span").innerHTML = response["num_likes"];
            document.getElementById("like-icon").className = response["liked"] == 0 ? "bi bi-fire" : "bi bi-fire like-clicked";
            document.getElementById("user_icon").username = response["username"];
            document.getElementById("username-span").innerHTML = response["username"];
            document.getElementById("user_icon_img").src = "/FableFlow/resources/icons/" + response["user_icon"];
        },
        error: function(error) {
            console.log("Error loading page content.");
            console.log(error);
        }
    });
});

// Add an onclick-event listener to an HTML element
function addClickListener(elementId, callback) {
    let element = document.getElementById(elementId);
    const chapterId = getChapterId(window.location.href);
    
    if (element) {
        element.addEventListener('click', function() {
            callback(chapterId);
        });
    } else {
        console.error('Button not found:', elementId);
    }
}

function loadContent(subpage, callback=function() {}) {
    $.ajax({
        type: "GET",
        url: "SubChapterPage.php",
        data: { subpage: subpage },
        success: function(response) {
            $("#subpageContent").html(response);
            callback();
        },
        error: function() {
            console.log("Error loading subpage content.");
        }
    });
}

function updateChapterLike(chapterId) {
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/UpdateChapterLike.php",
        data: { chapterId: chapterId },
        success: function(response) {
            response = JSON.parse(response);
            document.getElementById("like-span").innerHTML = response["likes"];
            document.getElementById("like-icon").className = response["status"] == 0 ? "bi bi-fire" : "bi bi-fire like-clicked";
            
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
function initializeProposals() {
    loadProposals();
}

function loadProposals() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetProposals.php',
        type: 'GET',
        data: { chapter_id: getChapterId(window.location.href) },
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var proposalsContainer = $('#proposals-container');
                data.forEach(function(proposal) {
                    var newProposalHtml = createProposalHtml(proposal);
                    proposalsContainer.append(newProposalHtml);

                    addClickListener(proposal.proposalId, function() {
                        loadContent('read-proposal', function() {
                            // Load proposal informations
                            document.getElementById("proposal-title").innerHTML = proposal["title"];
                            document.getElementById("proposal-time").innerHTML = getTimeAgo(proposal["publicationDatetime"]);
                            document.getElementById("proposal-like-span").innerHTML = proposal["num_likes"];
                            document.getElementById("proposal-content").innerHTML = proposal["content"];
                            document.getElementById("proposal-like-icon").addEventListener('click', function() {
                                updateProposalLike(proposal["proposalId"]);
                            });
                            
                            // Load comments
                            loadProposalComments(proposal["proposalId"]);
                            
                            document.getElementById("proposal-send-button").addEventListener('click', function() {
                                var message = $("#proposal-message-input").val();
                                
                                $.ajax({
                                    url: "/FableFlow/src/server/api/PostProposalComment.php",
                                    type: "POST",
                                    data: { proposalId: proposal["proposalId"], content: message },
                                    dataType: "json",
                                    success: function(response) {
                                        $("#message-input").val("");
                                        console.log(response);
                                        // Clear the comments container
                                        var commentsContainer = $("#proposal-comments-container");
                                        commentsContainer.empty();

                                        // Reload the comments
                                        loadProposalComments(proposal["proposalId"]);
                                    },
                                    error: function(error) {
                                        console.error("Error loading comments:", error);
                                    }
                                });
                            });

                            //document.getElementById("proposal-user-icon").src = proposal["user"]["icon"];                            
                        });                        
                    });
                });
            } else {
                console.log('No more proposals');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading proposals:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function createProposalHtml(proposal) {
    return `
    <div id="${proposal.proposalId}" class="proposal">
        <div class="container-fluid">
            <div class="row user-info">
                <div class="col-8">
                    <img src="${proposal.user.icon}" alt="User Icon" width="30" height="30">
                    <span>${proposal.user.username}</span>
                </div>
                <div class="col-4 time-text">
                    <span>${getTimeAgo(proposal.publicationDatetime)}</span>
                </div>
            </div>

            <div class="row proposal-title">
                <div class="col-10">
                    ${proposal.title}
                </div>        
                <div class="col-2 proposal-details">
                    <span><i class="bi bi-chat-dots"></i>${proposal.num_comments}</span>
                    <span><i class="bi bi-fire"></i>${proposal.num_likes}</span>
                </div>
            </div>
            <div class="row proposal-content">
                ${proposal.content}
            </div>
        </div>
    </div>`;
}

// Get the id of the post from the URL
function getChapterId(currentURL) {
    var match = currentURL.match(/id=([^&]*)/);
    return match ? match[1] : null;
}
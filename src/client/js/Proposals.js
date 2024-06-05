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
                        loadContent('read-proposal', proposal.proposalId, function() {
                            // load proposal informations
                            console.log(document.getElementById("proposal-title"));
                            document.getElementById("proposal-title").innerHTML = proposal["title"];
                            document.getElementById("proposal-time").innerHTML = getTimeAgo(proposal["publicationDatetime"]);
                            document.getElementById("proposal-like-span").innerHTML = proposal["num_likes"];
                            document.getElementById("proposal-content").innerHTML = proposal["content"];
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

function getTimeAgo(mysqlDatetime) {
    var mysqlDate = new Date(mysqlDatetime);
    var currentDate = new Date();

    var timeDifference = currentDate.getTime() - mysqlDate.getTime();

    var seconds = Math.floor(timeDifference / 1000);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);

    if (days > 0) {
        return days + ' days ago';
    } else if (hours > 0) {
        return hours + ' hours ago';
    } else if (minutes > 0) {
        return minutes + ' minutes ago';
    } else {
        return seconds + ' seconds ago';
    }
}

// Get the id of the post from the URL
function getChapterId(currentURL) {
    var match = currentURL.match(/id=([^&]*)/);
    return match ? match[1] : null;
}
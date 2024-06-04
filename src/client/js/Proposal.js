var newProposalButton = document.getElementById('new-proposal-button');
var hiddenChapterId = document.getElementById('hidden-chapter-id');

setInterval(function(){
    if (newProposalButton !== document.getElementById('new-proposal-button') && document.getElementById('new-proposal-button') !== null) {
        newProposalButton = document.getElementById('new-proposal-button');

        addClickListener('new-proposal-button', function(storyId) {
            loadContent('create-proposal', storyId);
        });
    }

    if (hiddenChapterId !== document.getElementById('hidden-chapter-id') && document.getElementById('hidden-chapter-id') !== null ) {
        hiddenChapterId = document.getElementById('hidden-chapter-id');

        document.getElementById('hidden-chapter-id').value = getPostId(window.location.href);
    }
}, 500);

function initializeProposals() {
    loadProposals();
}

function loadProposals() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetProposals.php',
        type: 'GET',
        data: { chapter_id: getPostId(window.location.href) },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.length > 0) {
                var proposalsContainer = $('#proposals-container');
                data.forEach(function(proposal) {
                    var newProposalHtml = createProposalHtml(proposal);
                    proposalsContainer.append(newProposalHtml);
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
    <div id="${proposal.chapterId}" class="proposal">
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
function getPostId(currentURL) {
    var match = currentURL.match(/id=([^&]*)/);
    return match ? match[1] : null;
}
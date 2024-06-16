let names = [];

$(document).ready(function() {
    $('#notification-icon').click(function() {
        $('#notification-menu').toggle();
    });

    // Check for new notifications every 3 seconds
    setInterval(function() {
        $.ajax({
            url: '/FableFlow/src/server/api/GetNotifications.php',
            type: 'GET',
            dataType: 'json',
            success: function(notifications) {
                $('#notification-list').empty();

                if (Array.isArray(notifications)) {
                    
                    notifications.forEach(function(notification) {
                        $('#notification-list').append('<li data-id=\'' + notification['id'] + '\' class="clickable-text">' + notification.content + ' (' + getTimeAgo(notification.datetime) + ')' + '</li>');
                        $('#notification-list [data-id="' + notification['id'] + '"]').click(function() {
                            deleteNotification(notification['id']);
                        });
                    });
                    
                    // Update the notification icon
                    if (notifications.length > 0) {
                        $('#notification-icon').removeClass('bi-bell');
                        $('#notification-icon').addClass('bi-bell-fill');
                    } else {
                        $('#notification-icon').removeClass('bi-bell-fill');
                        $('#notification-icon').addClass('bi-bell');
                }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading notifications:', textStatus, errorThrown);
                console.log(jqXHR.responseText);
            }
        });
    }, 250);

    // Fetch names from the server on page load
    $.ajax({
        url: '/FableFlow/src/server/api/GetUsers.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            names = data;
        }
    });

    // Event listener for the search input
    $('#search-text').on('input', function() {
        const query = $(this).val();
        if (query.length==0) {
            $('#users-found').empty();
        } else {
            searchNames(query);
        }
    });
});

function searchNames(query) {
    const lowerQuery = query.toLowerCase();

    // Filter names by checking if they contain the query as a substring
    const results = names.filter(user => user.username.toLowerCase().includes(lowerQuery));

    // Sort results by the position of the query in the name
    results.sort((a, b) => a.username.toLowerCase().indexOf(lowerQuery) - b.username.toLowerCase().indexOf(lowerQuery));

    // Display results
    $('#users-found').empty();
    results.forEach(result => {
        $('#users-found').append(`<li>
                                    <a href="/FableFlow/src/client/profile/Profile.php?user_viewing=${result.username}">
                                        <div class="searched_user_container">
                                            <span>
                                                ${result.username}
                                            </span>
                                            <img alt="user ${result.username}" src='/FableFlow/resources/icons/${result.icon}'>
                                            </img>
                                        </div>
                                    </a>
                                </li>`);
    });
}

function deleteNotification(notificationId) {
    $.ajax({
        url: '/FableFlow/src/server/api/DeleteNotification.php',
        type: 'POST',
        data: { notificationId: notificationId },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error deleting notifications:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}


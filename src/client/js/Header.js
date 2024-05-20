$(document).ready(function() {
    $('#notification_icon').click(function() {
        $('#notification_menu').toggle();
    });

    // Check for new notifications every 3 seconds
    setInterval(function() {
        $.ajax({
            url: '/FableFlow/src/server/api/GetNotifications.php',
            type: 'GET',
            dataType: 'json',
            success: function(notifications) {
                $('#notification_list').empty();

                if (Array.isArray(notifications)) {
                    
                    notifications.forEach(function(notification) {
                        $('#notification_list').append('<li data-id=\'' + notification['id'] + '\' class="clickable-text">' + notification.content + ' (' + getTimeAgo(notification.datetime) + ')' + '</li>');
                        $('#notification_list [data-id="' + notification['id'] + '"]').click(function() {
                            deleteNotification(notification['id']);
                        });
                    });
                    
                    // Update the notification icon
                    if (notifications.length > 0) {
                        $('#notification_icon').removeClass('bi-bell');
                        $('#notification_icon').addClass('bi-bell-fill');
                    } else {
                        $('#notification_icon').removeClass('bi-bell-fill');
                        $('#notification_icon').addClass('bi-bell');
                }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading notifications:', textStatus, errorThrown);
                console.log(jqXHR.responseText);
            }
        });
    }, 250);
});

function getTimeAgo(mysqlDatetime) {
    let mysqlDate = new Date(mysqlDatetime);
    let currentDate = new Date();

    let timeDifference = currentDate.getTime() - mysqlDate.getTime();

    let seconds = Math.floor(timeDifference / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    let days = Math.floor(hours / 24);

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
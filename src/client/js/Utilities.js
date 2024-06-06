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

function getChapterImagePath(chapterImageFileName) {
    return `/FableFlow/resources/images/${chapterImageFileName}`;
}

function getIconImagePath(iconImageFileName) {
    return `/FableFlow/resources/icons/${iconImageFileName}`;
}
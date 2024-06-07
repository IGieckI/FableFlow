function getTimeAgo(mysqlDatetime) {
    const mysqlDate = new Date(mysqlDatetime);
    const currentDate = new Date();

    const timeDifference = currentDate.getTime() - mysqlDate.getTime();

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

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

function goToProfile(username) {
    window.location.assign('/FableFlow/src/client/profile/Profile.php?user_viewing=' + username);
}
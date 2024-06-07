function initializePoolOverview() {
    loadPools();
}

function loadPools() {
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetPools.php",
        data: { chapterId: getChapterId(window.location.href) },
        dataType: 'json',
        success: function(response) {
            response['pools'].forEach(pool => {
                let item = document.createElement('li');
                createPool(item, pool);
                document.querySelector('#pool-list').appendChild(item);
            });
        },
        error: function() {
            console.log("Error loading page content.");
        }
    });
}

function createPool(li, pool) {
    li.innerHTML=   `
                    <article class="pool-link">
                        <span class="pool-title">${pool['title']}
                        </span>
                        <span class="pool-expiration">${howMuchTimeLeft(pool['expire_datetime'])}</span>
                    </article>
                    `;
}

function howMuchTimeLeft(date_r) {
    // Parse the input date string into a JavaScript Date object
    const targetDate = new Date(date_r);
    // Get the current date and time
    const currentDate = new Date();
    // Calculate the difference in time (in seconds)
    const timeDifference = (targetDate - currentDate) / 1000;
    
    // If the time difference is negative, the date has passed
    if (timeDifference < 0) {
        return 'expired';
    } else {
        const daysLeft = Math.ceil(timeDifference / (60 * 60 * 24));
        if (timeDifference < 86400) {
            return ' expires today at ' + targetDate.getHours() + ":" + targetDate.getMinutes() + ":" + targetDate.getSeconds();
        } else {
            return ' expires in ' + daysLeft + ' days';
        }
        
    }
}
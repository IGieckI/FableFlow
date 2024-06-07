function initializePoolOverview(chapterId) {
    loadPools(chapterId);
}

function loadPools(chapterId) {
    /* Request to see if i can create a pool for this chapter*/

    $.ajax({
        type: "GET",
        url: '/FableFlow/src/server/api/GetAuthor.php',
        data: { chapter_id: getChapterId(window.location.href) },
        dataType: 'json',
        success: function(response) {
            console.log("CCCCCCCCCCCCCCCCC"+chapterId);
            if (response['author']!=null) {
                $.ajax({
                    url: '/FableFlow/src/server/api/GetLoggedUsername.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {  
                        if (response['author']==data['result']) {
                            let createButton = document.createElement('button');
                            createButton.className = 'create-pool'
                            createButton.innerText = "Create a new pool!";
                            createButton.addEventListener('click', function() {
                                loadContent('create-pool', function(){
                                    loadPoolCreation(chapterId);
                                });
                            });
                            document.querySelector('#create-pool').appendChild(createButton);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Failed AJAX call in logging checking: ', textStatus, errorThrown);
                        console.log(jqXHR.responseText);
                    }
                });
                
            } else {
                // Manually reject the promise to trigger the error callback
                $.Deferred().reject('Author not found').promise().fail(function() {
                    console.log("Error in author detection script");
                });
            }
        },
        error: function() {
            console.log("Error in author detection script");
        }
    });

    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetPools.php",
        data: { chapterId: getChapterId(window.location.href) },
        dataType: 'json',
        success: function(response) {
            response['pools'].forEach(pool => {
                let item = document.createElement('li');
                createPool(item, pool);
                item.addEventListener('click', function() {
                    loadContent('pool-view', function(){
                        //add here the call to the pool-view js file initializator
                    });
                })
                document.querySelector('#pool-list').appendChild(item);
            });
        },
        error: function() {
            console.log("Error loading pools");
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
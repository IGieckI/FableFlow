<?php
    // Simulating database retrieval of posts
    $posts = [
        [
            'id' => 1, 'chapter_id' => 101, 'username' => 'user1', 'user_icon' => 'path/to/icon1.png', 
            'time' => '2023-05-18 10:00:00', 'post_title' => 'Post Title 1', 
            'num_comments' => 5, 'num_likes' => 10, 'post_content' => 'Post content 1'
        ],
        [
            'id' => 2, 'chapter_id' => 102, 'username' => 'user2', 'user_icon' => 'path/to/icon2.png', 
            'time' => '2023-05-18 11:00:00', 'post_title' => 'Post Title 2', 
            'num_comments' => 3, 'num_likes' => 20, 'post_content' => 'Post content 2'
        ],
        [
            'id' => 3, 'chapter_id' => 103, 'username' => 'user3', 'user_icon' => 'path/to/icon3.png', 
            'time' => '2023-05-18 12:00:00', 'post_title' => 'Post Title 3', 
            'num_comments' => 7, 'num_likes' => 15, 'post_content' => 'Post content 3'
        ],
        // Add more posts as needed
    ];
?>

<div id="proposals-container">
    
    <button id="new-proposal-button" type="button" class="btn custom-btn mb-5">Create a new proposal!</button>

    <?php foreach ($posts as $post): ?>
        <div id="<?= $post['chapter_id'] ?>" class="proposal">
            <div class="container-fluid">
                <div class="row user-info">
                    <div class="col-8">
                        <img src="${post.user_icon}" alt="User Icon" width="30" height="30">
                        <span><?= $post['username'] ?></span>
                    </div>
                    <div class="col-4 time-text">
                        <span><?= $post['time'] ?></span>
                    </div>
                </div>

                <div class="row proposal-title">
                    <div class="col-10">
                        <?= $post['post_title'] ?>
                    </div>        
                    <div class="col-2 proposal-details">
                        <span><i class="bi bi-chat-dots"></i><?= $post['num_comments'] ?></span>
                        <span><i class="bi bi-fire"></i><?= $post['num_likes'] ?></span>
                    </div>
                </div>
                <div class="row proposal-content">
                    <?= $post['post_content'] ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function loadMorePosts() {
        // Example: Fetch more posts from the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'load_more_posts.php', true); // Endpoint to load more posts
        xhr.onload = function() {
            if (xhr.status === 200) {
                var newPosts = document.createElement('div');
                newPosts.innerHTML = xhr.responseText;
                document.getElementById('posts-container').appendChild(newPosts);
            }
        };
        xhr.send();
    }

    // Example event listener for loading more posts
    window.addEventListener('scroll', function() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
            loadMorePosts();
        }
    });
});

function redirectToPostPage(chapterId) {
    // Implement redirection logic
    window.location.href = 'post_page.php?chapter_id=' + chapterId;
}
</script>

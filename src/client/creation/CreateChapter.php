<?php  
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    array_push($_SESSION['jsFiles'], '/FableFlow/src/client/js/Chapters.js');

    require "../Header.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="text-center">
                        <h2>Create a new Chapters</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="proposal-form" action="/FableFlow/src/server/api/PostChapter.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="hidden-chapter-id" name="hidden-chapter-id">
                        <div class="form-group">
                            <p class="mb-2">Select your story:</p>
                            <select id="story-title" name="story-title" class="form-control">
                                <!--Options of the various stories, will be loaded here from Chapters.js-->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="chapter-title">Chapter Title</label>
                            <input type="text" id="chapter-title" name="chapter-title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="chapter-image">Upload Image</label>
                            <input type="file" id="chapter-image" name="chapter-image" class="form-control-file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="mt-5 d-flex justify-content-center form-group">
                            <button id="submit-proposal-button" type="submit" class="btn btn-primary">Create Chapters</button>
                        </div>
                        <div class="mt-3 form-group text-center">
                            <a href="CreateStory.php" class="btn btn-secondary">Create a New Story</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require "../Footer.php";
?>
<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require '../Header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="text-center">
                    <h2>Create a new Story</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="proposal-form" action="/FableFlow/src/server/api/PostStory.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="hidden-chapter-id" name="hidden-chapter-id">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="mt-5 d-flex justify-content-center form-group">
                            <button id="submit-proposal-button" type="submit" class="btn btn-primary">Create Story</button>
                        </div>
                    </form>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="CreateChapter.php" class="btn btn-secondary">Create a New Chapter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require '../Footer.php';
?>

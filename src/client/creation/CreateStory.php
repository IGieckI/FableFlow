<?php 
require __DIR__. '/FableFlow/src/client/Header.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Create a New Story</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Create a new Story</h2>
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
                            <a href="CreateChapters.php" class="btn btn-secondary">Go to Create Chapter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
    require __DIR__. '/FableFlow/src/client/Footer.php';
?>

<?php 
//require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Header.php';
require __DIR__. '/FableFlow/src/client/Header.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Create a new Chapters</title>
    <!-- Includi il CSS di Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="/FableFlow/src/client/js/Chapters.js"></script>
</head>
<body>
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
                        <form id="proposal-form" action="/FableFlow/src/server/api/PostChapters.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="hidden-chapter-id" name="hidden-chapter-id">
                            <div class="form-group">
                                <p class="mb-2">Select your story:</p>
                                <select name="story_title" class="form-control">
                                    <!-- Opzioni per le storie verranno aggiunte dinamicamente qui -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="chapter_title">Chapter Title</label>
                                <input type="text" id="chapter_title" name="chapter_title" class="form-control" required>
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

    <!-- Includi JavaScript di Bootstrap e dipendenze -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
    require __DIR__. '/FableFlow/src/client/Footer.php';
?>
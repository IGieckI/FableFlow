<!DOCTYPE HTML>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Pool Creation</title>   
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/pool_creation.css">
    <script src="https://kit.fontawesome.com/8d29eebb64.js" crossorigin="anonymous"></script>
    <script src="js/pool_creation.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<main>
    <label for="title">Pool title:</label>
    <textarea id="title" name="title" rows="1" columns="20" maxlength="20" oninput="removeNewlines(this); checkForTitleLength(this);">
        Here goes your pool's title...
    </textarea>

    <label for="pool_description">Content:</label>
    <textarea id="pool_description" name="pool_description" rows="10"></textarea>

    <br>

    <button onclick="showRadioBox()">Plus</button>

    <ul id="options-list">
        <li>
            <label>
                <input type="radio" name="options" value="Option 1"> Option 1
            </label>
            <i class="fa-regular fa-trash-can" onclick="deleteOption(this)"></i>
        </li>
        <li>
            <label>
                <input type="radio" name="options" value="Option 2"> Option 2
            </label>
            <i class="fa-regular fa-trash-can" onclick="deleteOption(this)"></i>
        </li>
        <li>
            <label>
                <input type="radio" name="options" value="Option 3"> Option 3
            </label>
            <i class="fa-regular fa-trash-can" onclick="deleteOption(this)"></i>
        </li>
        <!-- Add more list items for additional options -->
    </ul>

</main>
<?php include 'footer.php'; ?>
</body>
</html>
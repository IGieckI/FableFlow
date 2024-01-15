
<?php
require('config.php');
require('dbhelper.php');

// Define the number of posts to load at a time
$postsPerPage = 5;

// Number of page to retrieve
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting point for retrieving posts (if 0 start from post 1)
$start = ($page - 1) * $postsPerPage;

// Fetch posts from the database (replace with your actual database query)
$query = "SELECT * FROM stories LIMIT $start, $postsPerPage;";
$result = findBy([], $postsPerPage, $start, 'stories');

// Send the posts as JSON to the client
echo json_encode($result);
?>

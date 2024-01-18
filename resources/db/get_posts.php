<?php
require('config.php');
require('dbhelper.php');

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

// Define the number of posts to load at a time
$postsPerPage = 5;

// Number of page to retrieve
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is not less than 1

// Calculate the starting point for retrieving posts
$start = ($page - 1) * $postsPerPage;

try {
    // Fetch posts from the database (replace with your actual database query)
    $result = $db->findBy([], $postsPerPage, $start, Tables::Stories);

    // Set the Content-Type header
    header('Content-Type: application/json');

    // Send the posts as JSON to the client
    echo json_encode($result);
} catch (Exception $e) {
    // Handle errors appropriately
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
?>

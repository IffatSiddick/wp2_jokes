<?php
try {
    include 'includes/DatabaseConnection.php';
    include 'classes/DatabaseTable.php';
    include 'controllers/JokeController.php';

    $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
    $author_table = new DatabaseTable($pdo, 'author', 'id');

    $joke_controller = new JokeController($jokes_table, $author_table);

    $action = $_GET['action'] ?? 'home';
    $page = $joke_controller->$action();

    $title = $page['title'];
    $output = $page['output'];
}
catch (PDOException $e) {
    $title = 'An error has occured';
    $output= 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';

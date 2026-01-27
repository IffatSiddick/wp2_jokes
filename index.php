<?php
function loadTemplate($TemplateFileName, $variables = []) {
    extract($variables);
    ob_start();
    include 'templates/'.$TemplateFileName;
    return ob_get_clean();
}

try {
    include 'includes/DatabaseConnection.php';
    include 'classes/DatabaseTable.php';
    include 'controllers/JokeController.php';

    $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
    $author_table = new DatabaseTable($pdo, 'author', 'id');

    $joke_controller = new JokeController($jokes_table, $author_table);

    $action = $_GET['action'] ?? 'home';

    if ($action == strtolower($action)) {
        $joke_controller->$action();
    }
    else {
        http_response_code(302);
        header('index.php?action='.strtolower($action));
        exit;
    }

    $page = $joke_controller->$action();

    $title = $page['title'];
    $variables = $page['variables'] ?? [];
    $output = loadTemplate($page['template'], $variables);
}
catch (PDOException $e) {
    $title = 'An error has occured';
    $output= 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';

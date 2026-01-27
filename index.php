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
    include 'controllers/AuthorController.php';

    $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
    $author_table = new DatabaseTable($pdo, 'author', 'id');

    $action = $_GET['action'] ?? 'home';

    $controller_name = $_GET['controller'] ?? 'joke';

    if ($controller_name == 'joke') {
        $controller = new JokeController($jokes_table, $author_table);
    }
    elseif ($controller_name == 'author') {
        $controller = new AuthorController($author_table);
    }

    if ($action == strtolower($action) && 
    $controller_name ==  strtolower($controller_name)) {
        $page = $controller->$action();
    }
    else {
        http_response_code(301);
        header('index.php?controller='.strtolower($controller_name).
        '&action='.strtolower($action));
        exit;
    }

    $title = $page['title'];
    $variables = $page['variables'] ?? [];
    $output = loadTemplate($page['template'], $variables);
}
catch (PDOException $e) {
    $title = 'An error has occured';
    $output= 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';

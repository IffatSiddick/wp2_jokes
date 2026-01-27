<?php
    try{
        include 'includes/DatabaseConnection.php';
        include 'classes/DatabaseTable.php';

        $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
        $author_table = new DatabaseTable($pdo, 'author', 'id');

        if (isset($_POST['joke'])){
            $joke = $_POST['joke'];
            $joke['jokedate'] = date('Y-m-d');
            $joke['authorId'] =1;

            $jokes_table->save($joke); 

            header('location: jokes.php?action=list');
        } 
        else {
            if (isset($_GET['id'])) {
                $joke = $jokes_table->find('id', $_GET['id'])[0] ?? null;
            }
            else {
                $joke = null;
            }
            $title = 'Edit Joke';

            ob_start();
            include 'templates/editjoke.html.php';
            $output = ob_get_clean();
        }
    }
    catch (PDOException $e) {
        $title = 'An error has occured';
        $output= 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';

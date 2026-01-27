<?php
try{
    include 'includes/DatabaseConnection.php';
    include 'classes/DatabaseTable.php';

    $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
        
    $jokes_table->delete('id', $_POST['id']);  
    header('location: jokes.php');

}
catch(PDOException $e) {
    $title = 'An error has occured';
    $output = 'Unable to connect to delete joke: ' .$e->getMessage();
}
include 'templates/layout.html.php';


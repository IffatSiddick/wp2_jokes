<?php
try{
    include 'includes/DatabaseConnection.php';
    include 'classes/DatabaseTable.php';

    $jokes_table = new DatabaseTable($pdo, 'joke', 'id');
    $author_table = new DatabaseTable($pdo, 'author', 'id');
        
    $result = $jokes_table->findAll();
    
    $jokes = [];
    foreach($result as $joke){
        $author = $author_table->find('id', $joke['authorid'])[0];

        $jokes[] = [
            'id' => $joke['id'], 
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }
    $title = 'Joke list';
    $totalJokes = $jokes_table->total();

    ob_start();
    include 'templates/jokes.html.php';
    $output = ob_get_clean();

}catch (PDOException $e){
    $title = 'An error has occured';
    $output= 'Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';
<?php
class JokeController {
    private DatabaseTable $JokeTable;
    private DatabaseTable $AuthorTable;

    public function __construct(DatabaseTable $JokeTable, DatabaseTable $AuthorTable) {
        $this->JokeTable = $JokeTable;
        $this->AuthorTable = $AuthorTable;
    }

    public function list() {
        $result = $this->JokeTable->findAll();
    
        $jokes = [];
        foreach($result as $joke){
            $author = $this->AuthorTable->find('id', $joke['authorid'])[0];

            $jokes[] = [
                'id' => $joke['id'], 
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        }
        $title = 'Joke list';
        $totalJokes = $this->JokeTable->total();

        ob_start();
        include 'templates/jokes.html.php';
        $output = ob_get_clean();

        return ['output' => $output, 'title'=>$title];
    }

    public function home() {
        $title = 'Internet Joke Database';
        ob_start();
        include 'templates/home.html.php';
        $output = ob_get_clean();

        return ['output' => $output, 'title'=>$title];
    }

    public function delete() {
        $this->JokeTable->delete('id', $_POST['id']);  
        header('location: index.php?action=list');
    }

    public function edit() {
        if (isset($_POST['joke'])){
            $joke = $_POST['joke'];
            $joke['jokedate'] = date('Y-m-d');
            $joke['authorId'] =1;

            $this->JokeTable->save($joke); 

            header('location: index.php?action=list');
        } 
        else {
            if (isset($_GET['id'])) {
                $joke = $this->JokeTable->find('id', $_GET['id'])[0] ?? null;
            }
            else {
                $joke = null;
            }
            $title = 'Edit Joke';

            ob_start();
            include 'templates/editjoke.html.php';
            $output = ob_get_clean();
        }

        return ['output' => $output, 'title'=>$title];
    }
}
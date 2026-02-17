<?php
class JokeController {
    private DatabaseTable $JokeTable;
    private DatabaseTable $AuthorTable;

    public function __construct(DatabaseTable $JokeTable, DatabaseTable $AuthorTable,
    private Authentication $authentication) {
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

        return ['template' => 'jokes.html.php', 
                'title'=> $title,
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes
                    ]
                ];
    }

    public function home() {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title'=>$title];
    }

    public function delete() {
        $this->JokeTable->delete('id', $_POST['id']);  
        header('location: index.php?controller=joke&action=list');
    }

    public function edit() {
        if (!$this->authentication->isLoggedIn()) {
            return ['template' => 'error.html.php', 
            'title'=>'You are not authorised to use this page.'];
        }
        else {
            if (isset($_POST['joke'])){
                $joke = $_POST['joke'];
                $joke['jokedate'] = date('Y-m-d');
                $joke['authorId'] =1;

                $this->JokeTable->save($joke); 

                header('location: index.php?controller=joke&action=list');
            } 
            else {
                if (isset($_GET['id'])) {
                    $joke = $this->JokeTable->find('id', $_GET['id'])[0] ?? null;
                }
                else {
                    $joke = null;
                }
                $title = 'Edit Joke';

                return ['template' => 'editjoke.html.php',
                    'title'=>$title,
                    'variables' => ['joke' => $joke]
                ];
            }
        }
    }
}
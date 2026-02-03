<?php
class AuthorController {
    private DatabaseTable $AuthorTable;

    public function __construct(DatabaseTable $authorsTable) {
        $this->authorTable = $authorsTable;
    }

    public function registrationform() {
        return [
            'template' => 'register.html.php',
            'title' => 'Register an account!'
        ];
    }

    public function regFormSubmit() {
        $author = $_POST['author'];

        $this->authorTable->save($author);
        header('location: index.php?controller=author&action=success');
    }

    public function success() {
        return [
            'template' => 'registerSuccess.html.php',
            'title' => 'Registration successful!'
        ];
    }
}
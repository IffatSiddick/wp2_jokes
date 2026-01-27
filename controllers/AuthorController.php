<?php
class AuthorController {
    private DatabaseTable $JokeTable;
    private DatabaseTable $AuthorTable;

    public function __construct(DatabaseTable $authorsTable) {
        $this->AuthorTable = $authorsTable;
    }

    public function registrationForm() {
        return [
            'template' => 'register.html.php',
            'title' => 'Register an account!'
        ];
    }

    public function success() {
        return [
            'template' => 'registerSuccess.html.php',
            'title' => 'Registration successful!'
        ];
    }
}
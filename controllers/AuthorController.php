<?php
class AuthorController {
    private DatabaseTable $authorTable;

    public function __construct(DatabaseTable $inputTable) {
        $this->authorTable = $inputTable;
    }

    public function registrationform() {
        return [
            'template' => 'register.html.php',
            'title' => 'Register an account!'
        ];
    }

    public function regFormSubmit() {
        $author = $_POST['author'];

        #checking for errors
        $errors = [];

        if (empty($author['name'])) {
            $errors[] = "Name cannot be empty.";
        }

        if (empty($author['email'])) {
            $errors[] = "Email cannot be empty.";
        }
        elseif (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $errors[] = "Invalid email address";
        }
            if (count($this->authorTable->find('email', $author['email'])) > 0) {
                $errors[] = "This email has already been registered";
            }
            else {
                $author['email'] = strtolower($author['email']);
            }

        if (empty($author['password'])) {
            $errors[] = "Password cannot be empty.";
        }

        if (empty($errors)) {
            $this->authorTable->save($author);
            header('location: index.php?controller=author&action=success');
        }
        else {
            return [
            'template' => 'register.html.php',
            'title' => 'Register an account!',
            'variables' => [
                'errors' => $errors,
                'author' => $author
                ]
        ];
        }
    }

    public function success() {
        return [
            'template' => 'registerSuccess.html.php',
            'title' => 'Registration successful!'
        ];
    }
}
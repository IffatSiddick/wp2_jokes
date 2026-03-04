<?php
class Login {
    public function __construct(private Authentication $authentication) {}

    public function login() {
        return ['template' => 'login.html.php',
        'title' => 'Log in'];
    }

    public function loginsubmit() {
        $success = $this->authentication->login($_POST['email'], $_POST['password']);
    
        if ($success) {
            $author = $this->authentication->getUser();
            return ['template' => 'loginSuccess.html.php',
            'title' => 'Login successful',
            'variables' => ['author' => $author[0]['name']]
            ];
        }
        else {
            return ['template' => 'login.html.php',
            'title' => 'Log in',
            'variables' => ['errorMessage'=> true]
            ];
        }
    }

    public function logout() {
        $this->authentication->logout();
        header('location: index.php');
    }
}
?>

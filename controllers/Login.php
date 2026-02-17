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
            return ['template' => 'loginSuccess.html.php',
            'title' => 'Login successful'];
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
        header('location: /');
    }
}
?>
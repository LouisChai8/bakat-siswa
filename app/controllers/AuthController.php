<?php
namespace App\Controllers;

class AuthController
{

    public function profile()
    {
        require_once __DIR__ . '/../views/auth/profile.php';
    }

    public function LoginView()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

}
<?php
namespace App\Controllers;

class HomeController
{
    public function home()
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function addPost()
    {
        require_once __DIR__ . '/../views/addpost.php';
    }
}
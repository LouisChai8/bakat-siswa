<?php
namespace App\Controllers;

class AuthController
{
    // ── Start session safely ──
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ── GET /login ──
    public function LoginView(): void
    {
        $this->startSession();
        // Already logged in → go home
        if (!empty($_SESSION['user_id'])) {
            header('Location: /home');
            exit;
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // ── POST /login ──
    public function login(): void
    {
        $this->startSession();

        require_once __DIR__ . '/../core/Database.php';
        require_once __DIR__ . '/../models/UserModel.php';

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $error    = null;

        if ($username === '' || $password === '') {
            $error = 'Username and password are required.';
        } else {
            $model = new \App\Models\UserModel();
            $user  = $model->findByUsername($username);

            if (!$user || !password_verify($password, $user['password'])) {
                $error = 'Wrong username or password.';
            } else {
                // ✅ Login success — store user in session
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name']     = $user['name'];
                header('Location: /home');
                exit;
            }
        }

        // Re-render login page with error
        $_SESSION['login_error'] = $error;
        header('Location: /login');
        exit;
    }

    // ── GET /register ──
    public function registerView(): void
    {
        $this->startSession();
        if (!empty($_SESSION['user_id'])) {
            header('Location: /home');
            exit;
        }
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // ── POST /register ──
    public function register(): void
    {
        $this->startSession();

        require_once __DIR__ . '/../core/Database.php';
        require_once __DIR__ . '/../models/UserModel.php';

        $name     = trim($_POST['name']     ?? '');
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';
        $confirm  = $_POST['confirm']       ?? '';
        $error    = null;

        if (!$name || !$username || !$email || !$password) {
            $error = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email address.';
        } elseif (strlen($username) > 15) {
            $error = 'Username must be 15 characters or less.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } else {
            $model = new \App\Models\UserModel();

            if ($model->findByUsername($username)) {
                $error = 'Username is already taken.';
            } elseif ($model->findByEmail($email)) {
                $error = 'Email is already registered.';
            } else {
                // ✅ Register success
                $id = $model->create($name, $username, $email, $password);
                $_SESSION['user_id']  = $id;
                $_SESSION['username'] = $username;
                $_SESSION['name']     = $name;
                header('Location: /home');
                exit;
            }
        }

        $_SESSION['register_error'] = $error;
        $_SESSION['register_old']   = compact('name', 'username', 'email');
        header('Location: /register');
        exit;
    }

    // ── GET /logout ──
    public function logout(): void
    {
        $this->startSession();
        session_destroy();
        header('Location: /login');
        exit;
    }

    // ── GET /profile ──
    public function profile(): void
    {
        $this->startSession();
        require_once __DIR__ . '/../views/auth/profile.php';
    }

    // ── GET /editprofile ──
    public function editProfile(): void
    {
        $this->startSession();
        require_once __DIR__ . '/../views/editprofile.php';
    }
}
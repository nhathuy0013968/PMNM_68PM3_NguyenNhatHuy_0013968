<?php

class AuthController extends Controller
{
    private string $basePath = BASE_PATH;

    public function login(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/sinhvien');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('UserModel');
            $user = $userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                ];

                $this->redirect('/sinhvien');
            }

            $this->view('auth/login', [
                'title' => 'Đăng nhập',
                'error' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
                'old' => ['username' => $username],
                'basePath' => $this->basePath,
                'hideNav' => true,
            ]);
            return;
        }

        $this->view('auth/login', [
            'title' => 'Đăng nhập',
            'error' => '',
            'old' => [],
            'basePath' => $this->basePath,
            'hideNav' => true,
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);

        $this->redirect('/auth/login');
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $this->basePath . $path);
        exit;
    }
}

<?php

class LophocController extends Controller
{
    private string $basePath = BASE_PATH;

    public function index(): void
    {
        $lophocModel = $this->model('LophocModel');

        $this->view('lophoc/index', [
            'title' => 'Danh sách lớp học',
            'danhsachLophoc' => $lophocModel->getAll(),
            'basePath' => $this->basePath,
        ]);
    }

    public function create(): void
    {
        $this->view('lophoc/create', [
            'title' => 'Thêm lớp học',
            'error' => '',
            'old' => [],
            'basePath' => $this->basePath,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/lophoc');
        }

        $data = $this->getFormData();

        if ($data['tenlop'] === '') {
            $this->view('lophoc/create', [
                'title' => 'Thêm lớp học',
                'error' => 'Vui lòng nhập tên lớp.',
                'old' => $data,
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $lophocModel = $this->model('LophocModel');
        $lophocModel->create($data);

        $this->redirect('/lophoc');
    }

    public function edit($malop): void
    {
        $lophocModel = $this->model('LophocModel');
        $lophoc = $lophocModel->getById($malop);

        if (!$lophoc) {
            die('Không tìm thấy lớp học cần sửa.');
        }

        $this->view('lophoc/edit', [
            'title' => 'Sửa lớp học',
            'lophoc' => $lophoc,
            'error' => '',
            'basePath' => $this->basePath,
        ]);
    }

    public function update($malop): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/lophoc');
        }

        $data = $this->getFormData();
        $data['malop'] = $malop;

        if ($data['tenlop'] === '') {
            $this->view('lophoc/edit', [
                'title' => 'Sửa lớp học',
                'lophoc' => $data,
                'error' => 'Vui lòng nhập tên lớp.',
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $lophocModel = $this->model('LophocModel');
        $lophocModel->update($data);

        $this->redirect('/lophoc');
    }

    public function delete($malop): void
    {
        $lophocModel = $this->model('LophocModel');
        $lophocModel->delete($malop);

        $this->redirect('/lophoc');
    }

    private function getFormData(): array
    {
        return [
            'tenlop' => trim($_POST['tenlop'] ?? ''),
        ];
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $this->basePath . $path);
        exit;
    }
}

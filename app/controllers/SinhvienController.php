<?php

class SinhvienController extends Controller
{
    private string $basePath = BASE_PATH;

    public function index(): void
    {
        $sinhvienModel = $this->model('SinhvienModel');

        $perPage = 5;
        $totalRows = $sinhvienModel->countAll();
        $totalPages = max(1, (int) ceil($totalRows / $perPage));
        $currentPage = max(1, (int) ($_GET['page'] ?? 1));
        $currentPage = min($currentPage, $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $this->view('sinhvien/index', [
            'title' => 'Danh sách sinh viên',
            'danhsachSinhvien' => $sinhvienModel->getAll($perPage, $offset),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRows' => $totalRows,
            'perPage' => $perPage,
            'basePath' => $this->basePath,
        ]);
    }

    public function create(): void
    {
        $sinhvienModel = $this->model('SinhvienModel');

        $this->view('sinhvien/create', [
            'title' => 'Thêm sinh viên',
            'danhsachLophoc' => $sinhvienModel->getAllLophoc(),
            'error' => '',
            'old' => [],
            'basePath' => $this->basePath,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/sinhvien');
        }

        $data = $this->getFormData();
        $sinhvienModel = $this->model('SinhvienModel');
        $error = $this->validate($data, $sinhvienModel);

        if ($error !== '') {
            $this->view('sinhvien/create', [
                'title' => 'Thêm sinh viên',
                'danhsachLophoc' => $sinhvienModel->getAllLophoc(),
                'error' => $error,
                'old' => $data,
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $sinhvienModel->create($data);

        $this->redirect('/sinhvien');
    }

    public function edit($masv): void
    {
        $sinhvienModel = $this->model('SinhvienModel');
        $sinhvien = $sinhvienModel->getById($masv);

        if (!$sinhvien) {
            die('Không tìm thấy sinh viên cần sửa.');
        }

        $this->view('sinhvien/edit', [
            'title' => 'Sửa sinh viên',
            'sinhvien' => $sinhvien,
            'danhsachLophoc' => $sinhvienModel->getAllLophoc(),
            'error' => '',
            'basePath' => $this->basePath,
        ]);
    }

    public function update($masv): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/sinhvien');
        }

        $data = $this->getFormData();
        $data['masv'] = $masv;

        $sinhvienModel = $this->model('SinhvienModel');
        $error = $this->validate($data, $sinhvienModel, (int) $masv);

        if ($error !== '') {
            $this->view('sinhvien/edit', [
                'title' => 'Sửa sinh viên',
                'sinhvien' => $data,
                'danhsachLophoc' => $sinhvienModel->getAllLophoc(),
                'error' => $error,
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $sinhvienModel->update($data);

        $this->redirect('/sinhvien');
    }

    public function delete($masv): void
    {
        $sinhvienModel = $this->model('SinhvienModel');
        $sinhvienModel->delete($masv);

        $this->redirect('/sinhvien');
    }

    private function getFormData(): array
    {
        return [
            'mssv' => trim($_POST['mssv'] ?? ''),
            'hoten' => trim($_POST['hoten'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'sodienthoai' => trim($_POST['sodienthoai'] ?? ''),
            'ngaysinh' => $_POST['ngaysinh'] ?? '',
            'gioitinh' => $_POST['gioitinh'] ?? '',
            'diachi' => trim($_POST['diachi'] ?? ''),
            'malop' => $_POST['malop'] ?? null,
        ];
    }

    private function validate(array $data, SinhvienModel $sinhvienModel, ?int $excludeMasv = null): string
    {
        if ($data['mssv'] === '' || $data['hoten'] === '' || $data['email'] === '') {
            return 'Vui lòng nhập đầy đủ mã sinh viên, họ tên và email.';
        }

        if ($sinhvienModel->existsMssv($data['mssv'], $excludeMasv)) {
            return 'Mã sinh viên đã tồn tại, vui lòng nhập mã khác.';
        }

        return '';
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $this->basePath . $path);
        exit;
    }
}

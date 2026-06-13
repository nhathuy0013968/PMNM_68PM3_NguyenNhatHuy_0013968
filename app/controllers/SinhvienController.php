<?php

class SinhvienController extends Controller
{
    private string $basePath = BASE_PATH;

    public function index(): void
    {
        $sinhvienModel = $this->model('SinhvienModel');
        $search = trim($_GET['search'] ?? '');
        $sortBy = $_GET['sortBy'] ?? 'masv';
        $sortDir = strtoupper($_GET['sortDir'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        $perPage = 5;
        $totalRows = $sinhvienModel->countAll($search);
        $totalPages = max(1, (int) ceil($totalRows / $perPage));
        $currentPage = max(1, (int) ($_GET['page'] ?? 1));
        $currentPage = min($currentPage, $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $this->view('sinhvien/index', [
            'title' => 'Danh sách sinh viên',
            'danhsachSinhvien' => $sinhvienModel->getAll($perPage, $offset, $search, $sortBy, $sortDir),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRows' => $totalRows,
            'perPage' => $perPage,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
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
        $this->flash('success', 'Thêm sinh viên thành công.');
        $this->redirect('/sinhvien');
    }

    public function edit($masv): void
    {
        $sinhvienModel = $this->model('SinhvienModel');
        $sinhvien = $sinhvienModel->getById($masv);

        if (!$sinhvien) {
            $this->flash('error', 'Không tìm thấy sinh viên cần sửa.');
            $this->redirect('/sinhvien');
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
        $this->flash('success', 'Cập nhật sinh viên thành công.');
        $this->redirect('/sinhvien');
    }

    public function delete($masv): void
    {
        $sinhvienModel = $this->model('SinhvienModel');

        if (!$sinhvienModel->getById($masv)) {
            $this->flash('error', 'Sinh viên không tồn tại.');
            $this->redirect('/sinhvien');
        }

        $sinhvienModel->delete($masv);
        $this->flash('success', 'Xóa sinh viên thành công.');
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

    private function validate(array $data, SinhvienModel $model, ?int $excludeMasv = null): string
    {
        if ($data['mssv'] === '' || $data['hoten'] === '' || $data['email'] === '') {
            return 'Vui lòng nhập đầy đủ mã sinh viên, họ tên và email.';
        }

        if (!preg_match('/^[A-Za-z0-9_-]{4,20}$/', $data['mssv'])) {
            return 'Mã sinh viên phải có 4-20 ký tự, chỉ gồm chữ, số, dấu gạch ngang hoặc gạch dưới.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email không đúng định dạng.';
        }

        if ($data['sodienthoai'] !== '' && !preg_match('/^[0-9]{8,15}$/', $data['sodienthoai'])) {
            return 'Số điện thoại phải gồm 8-15 chữ số.';
        }

        if ($data['ngaysinh'] !== '' && $data['ngaysinh'] > date('Y-m-d')) {
            return 'Ngày sinh không được lớn hơn ngày hiện tại.';
        }

        if ($model->existsMssv($data['mssv'], $excludeMasv)) {
            return 'Mã sinh viên đã tồn tại, vui lòng nhập mã khác.';
        }

        if ($model->existsEmail($data['email'], $excludeMasv)) {
            return 'Email đã được sử dụng bởi sinh viên khác.';
        }

        return '';
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $this->basePath . $path);
        exit;
    }
}

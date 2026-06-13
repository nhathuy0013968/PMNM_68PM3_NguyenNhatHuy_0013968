<?php

class LophocController extends Controller
{
    private string $basePath = BASE_PATH;

    public function index(): void
    {
        $lophocModel = $this->model('LophocModel');
        $search = trim($_GET['search'] ?? '');
        $perPage = 5;
        $totalRows = $lophocModel->countAll($search);
        $totalPages = max(1, (int) ceil($totalRows / $perPage));
        $currentPage = max(1, (int) ($_GET['page'] ?? 1));
        $currentPage = min($currentPage, $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $this->view('lophoc/index', [
            'title' => 'Danh sách lớp học',
            'danhsachLophoc' => $lophocModel->getAll($perPage, $offset, $search),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRows' => $totalRows,
            'perPage' => $perPage,
            'search' => $search,
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
        $model = $this->model('LophocModel');
        $error = $this->validate($data, $model);

        if ($error !== '') {
            $this->view('lophoc/create', [
                'title' => 'Thêm lớp học',
                'error' => $error,
                'old' => $data,
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $model->create($data);
        $this->flash('success', 'Thêm lớp học thành công.');
        $this->redirect('/lophoc');
    }

    public function edit($malop): void
    {
        $model = $this->model('LophocModel');
        $lophoc = $model->getById($malop);

        if (!$lophoc) {
            $this->flash('error', 'Không tìm thấy lớp học cần sửa.');
            $this->redirect('/lophoc');
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
        $model = $this->model('LophocModel');
        $error = $this->validate($data, $model, (int) $malop);

        if ($error !== '') {
            $this->view('lophoc/edit', [
                'title' => 'Sửa lớp học',
                'lophoc' => $data,
                'error' => $error,
                'basePath' => $this->basePath,
            ]);
            return;
        }

        $model->update($data);
        $this->flash('success', 'Cập nhật lớp học thành công.');
        $this->redirect('/lophoc');
    }

    public function delete($malop): void
    {
        $model = $this->model('LophocModel');
        $lophoc = $model->getById($malop);

        if (!$lophoc) {
            $this->flash('error', 'Lớp học không tồn tại.');
        } elseif ($model->hasStudents($malop)) {
            $this->flash('error', 'Không thể xóa lớp đang có sinh viên. Hãy chuyển sinh viên sang lớp khác trước.');
        } else {
            $model->delete($malop);
            $this->flash('success', 'Xóa lớp học thành công.');
        }

        $this->redirect('/lophoc');
    }

    private function getFormData(): array
    {
        return [
            'malophoc' => trim($_POST['malophoc'] ?? ''),
            'tenlop' => trim($_POST['tenlop'] ?? ''),
            'ghichu' => trim($_POST['ghichu'] ?? ''),
        ];
    }

    private function validate(array $data, LophocModel $model, ?int $excludeMalop = null): string
    {
        if ($data['malophoc'] === '' || $data['tenlop'] === '') {
            return 'Vui lòng nhập đầy đủ mã lớp và tên lớp.';
        }

        if (!preg_match('/^[A-Za-z0-9_-]{2,20}$/', $data['malophoc'])) {
            return 'Mã lớp phải có 2-20 ký tự, chỉ gồm chữ, số, dấu gạch ngang hoặc gạch dưới.';
        }

        if (mb_strlen($data['tenlop']) > 100 || mb_strlen($data['ghichu']) > 255) {
            return 'Tên lớp hoặc ghi chú vượt quá độ dài cho phép.';
        }

        if ($model->existsMalophoc($data['malophoc'], $excludeMalop)) {
            return 'Mã lớp đã tồn tại.';
        }

        if ($model->existsTenlop($data['tenlop'], $excludeMalop)) {
            return 'Tên lớp đã tồn tại.';
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

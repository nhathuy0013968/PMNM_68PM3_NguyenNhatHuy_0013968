<div class="container">
    <div class="top-bar">
        <h2>Danh sách sinh viên</h2>
        <div class="nav-actions">
            <a class="btn btn-secondary" href="<?= $basePath ?>/lophoc">Quản lý lớp học</a>
            <a class="btn btn-add" href="<?= $basePath ?>/sinhvien/create">+ Thêm sinh viên</a>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Mã sinh viên</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Lớp</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($danhsachSinhvien)): ?>
            <?php foreach ($danhsachSinhvien as $sv): ?>
                <tr>
                    <td><?= htmlspecialchars($sv['masv']) ?></td>
                    <td><?= htmlspecialchars($sv['mssv']) ?></td>
                    <td><?= htmlspecialchars($sv['hoten']) ?></td>
                    <td><?= htmlspecialchars($sv['email']) ?></td>
                    <td><?= htmlspecialchars($sv['sodienthoai'] ?? '') ?></td>
                    <td><?= htmlspecialchars($sv['ngaysinh'] ?? '') ?></td>
                    <td><?= htmlspecialchars($sv['gioitinh'] ?? '') ?></td>
                    <td><?= htmlspecialchars($sv['diachi'] ?? '') ?></td>
                    <td><?= htmlspecialchars($sv['tenlop'] ?? 'Chưa có lớp') ?></td>
                    <td class="action">
                        <a href="<?= $basePath ?>/sinhvien/edit/<?= urlencode($sv['masv']) ?>" class="edit">Sửa</a>
                        <a href="<?= $basePath ?>/sinhvien/delete/<?= urlencode($sv['masv']) ?>"
                           class="delete"
                           onclick="return confirm('Bạn có chắc muốn xóa sinh viên này không?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" class="empty">Chưa có sinh viên nào.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination">
        <div>
            Tổng số: <?= htmlspecialchars($totalRows ?? 0) ?> sinh viên,
            trang <?= htmlspecialchars($currentPage ?? 1) ?>/<?= htmlspecialchars($totalPages ?? 1) ?>
        </div>

        <?php if (($totalPages ?? 1) > 1): ?>
            <div class="page-links">
                <?php if ($currentPage > 1): ?>
                    <a href="<?= $basePath ?>/sinhvien?page=<?= $currentPage - 1 ?>">Trước</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <?php if ($page === $currentPage): ?>
                        <span class="active"><?= $page ?></span>
                    <?php else: ?>
                        <a href="<?= $basePath ?>/sinhvien?page=<?= $page ?>"><?= $page ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?= $basePath ?>/sinhvien?page=<?= $currentPage + 1 ?>">Sau</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

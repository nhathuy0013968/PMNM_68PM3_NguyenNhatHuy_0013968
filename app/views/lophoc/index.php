<div class="container">
    <div class="top-bar">
        <h2>Danh sách lớp học</h2>
        <div class="nav-actions">
            <a class="btn btn-back" href="<?= $basePath ?>/sinhvien">Danh sách sinh viên</a>
            <a class="btn btn-add" href="<?= $basePath ?>/lophoc/create">+ Thêm lớp học</a>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Mã lớp</th>
            <th>Tên lớp</th>
            <th>Số sinh viên</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($danhsachLophoc)): ?>
            <?php foreach ($danhsachLophoc as $lop): ?>
                <tr>
                    <td><?= htmlspecialchars($lop['malop']) ?></td>
                    <td><?= htmlspecialchars($lop['tenlop']) ?></td>
                    <td><?= htmlspecialchars($lop['so_sinh_vien']) ?></td>
                    <td class="action">
                        <a href="<?= $basePath ?>/lophoc/edit/<?= urlencode($lop['malop']) ?>" class="edit">Sửa</a>
                        <a href="<?= $basePath ?>/lophoc/delete/<?= urlencode($lop['malop']) ?>"
                           class="delete"
                           onclick="return confirm('Bạn có chắc muốn xóa lớp học này không? Sinh viên thuộc lớp này sẽ chuyển sang trạng thái chưa có lớp.')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty">Chưa có lớp học nào.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

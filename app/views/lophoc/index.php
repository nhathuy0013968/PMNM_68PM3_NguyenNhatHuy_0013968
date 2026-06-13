<div class="container">
    <div class="top-bar">
        <h2>Danh sách lớp học</h2>
        <div class="nav-actions">
            <a class="btn btn-back" href="<?= $basePath ?>/sinhvien">Danh sách sinh viên</a>
            <a class="btn btn-add" href="<?= $basePath ?>/lophoc/create">+ Thêm lớp học</a>
        </div>
    </div>

    <form class="filter-bar" method="GET" action="<?= $basePath ?>/lophoc">
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm theo mã lớp, tên lớp hoặc ghi chú">
        <button class="btn btn-search" type="submit">Tìm kiếm</button>
        <?php if ($search !== ''): ?>
            <a class="btn btn-back" href="<?= $basePath ?>/lophoc">Xóa lọc</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Mã lớp</th>
            <th>Tên lớp</th>
            <th>Ghi chú</th>
            <th>Số sinh viên</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($danhsachLophoc)): ?>
            <?php foreach ($danhsachLophoc as $index => $lop): ?>
                <tr>
                    <td><?= (($currentPage - 1) * $perPage) + $index + 1 ?></td>
                    <td><?= htmlspecialchars($lop['malophoc']) ?></td>
                    <td><?= htmlspecialchars($lop['tenlop']) ?></td>
                    <td><?= htmlspecialchars($lop['ghichu'] ?? '') ?></td>
                    <td><?= htmlspecialchars($lop['so_sinh_vien']) ?></td>
                    <td class="action">
                        <a href="<?= $basePath ?>/lophoc/edit/<?= urlencode($lop['malop']) ?>" class="edit">Sửa</a>
                        <a href="<?= $basePath ?>/lophoc/delete/<?= urlencode($lop['malop']) ?>"
                           class="delete"
                           onclick="return confirm('Bạn có chắc muốn xóa lớp học này không?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="empty">Không tìm thấy lớp học phù hợp.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination">
        <div>Tổng số: <?= $totalRows ?> lớp học, trang <?= $currentPage ?>/<?= $totalPages ?></div>
        <?php if ($totalPages > 1): ?>
            <div class="page-links">
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <?php if ($page === $currentPage): ?>
                        <span class="active"><?= $page ?></span>
                    <?php else: ?>
                        <a href="<?= $basePath ?>/lophoc?page=<?= $page ?>&search=<?= urlencode($search) ?>"><?= $page ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$queryBase = 'search=' . urlencode($search) . '&sortBy=' . urlencode($sortBy) . '&sortDir=' . urlencode($sortDir);
$sortLink = function (string $column) use ($basePath, $search, $sortBy, $sortDir): string {
    $direction = ($sortBy === $column && $sortDir === 'ASC') ? 'DESC' : 'ASC';
    return $basePath . '/sinhvien?search=' . urlencode($search) . '&sortBy=' . urlencode($column) . '&sortDir=' . $direction;
};
?>
<div class="container wide">
    <div class="top-bar">
        <h2>Danh sách sinh viên</h2>
        <div class="nav-actions">
            <a class="btn btn-secondary" href="<?= $basePath ?>/lophoc">Quản lý lớp học</a>
            <a class="btn btn-add" href="<?= $basePath ?>/sinhvien/create">+ Thêm sinh viên</a>
        </div>
    </div>

    <form class="filter-bar" method="GET" action="<?= $basePath ?>/sinhvien">
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm theo mã, họ tên, email, SĐT hoặc lớp">
        <input type="hidden" name="sortBy" value="<?= htmlspecialchars($sortBy) ?>">
        <input type="hidden" name="sortDir" value="<?= htmlspecialchars($sortDir) ?>">
        <button class="btn btn-search" type="submit">Tìm kiếm</button>
        <?php if ($search !== ''): ?>
            <a class="btn btn-back" href="<?= $basePath ?>/sinhvien">Xóa lọc</a>
        <?php endif; ?>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>STT</th>
                <th><a class="sort-link" href="<?= $sortLink('mssv') ?>">Mã sinh viên</a></th>
                <th><a class="sort-link" href="<?= $sortLink('hoten') ?>">Họ tên</a></th>
                <th><a class="sort-link" href="<?= $sortLink('email') ?>">Email</a></th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th><a class="sort-link" href="<?= $sortLink('tenlop') ?>">Lớp</a></th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($danhsachSinhvien)): ?>
                <?php foreach ($danhsachSinhvien as $index => $sv): ?>
                    <tr>
                        <td><?= (($currentPage - 1) * $perPage) + $index + 1 ?></td>
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
                <tr><td colspan="10" class="empty">Không tìm thấy sinh viên phù hợp.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <div>Tổng số: <?= $totalRows ?> sinh viên, trang <?= $currentPage ?>/<?= $totalPages ?></div>
        <?php if ($totalPages > 1): ?>
            <div class="page-links">
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <?php if ($page === $currentPage): ?>
                        <span class="active"><?= $page ?></span>
                    <?php else: ?>
                        <a href="<?= $basePath ?>/sinhvien?page=<?= $page ?>&<?= $queryBase ?>"><?= $page ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

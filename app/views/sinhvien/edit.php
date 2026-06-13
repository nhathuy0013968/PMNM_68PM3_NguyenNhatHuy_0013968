<div class="container narrow">
    <h2>Sửa sinh viên</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= $basePath ?>/sinhvien/update/<?= urlencode($sinhvien['masv']) ?>">
        <div class="form-group">
            <label>Mã sinh viên</label>
            <input type="text" name="mssv" value="<?= htmlspecialchars($sinhvien['mssv'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Họ tên</label>
            <input type="text" name="hoten" value="<?= htmlspecialchars($sinhvien['hoten'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($sinhvien['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="sodienthoai" value="<?= htmlspecialchars($sinhvien['sodienthoai'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="ngaysinh" value="<?= htmlspecialchars($sinhvien['ngaysinh'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Giới tính</label>
            <select name="gioitinh">
                <option value="Nam" <?= (($sinhvien['gioitinh'] ?? '') === 'Nam') ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= (($sinhvien['gioitinh'] ?? '') === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="diachi"><?= htmlspecialchars($sinhvien['diachi'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Lớp</label>
            <select name="malop">
                <option value="">Chưa chọn lớp</option>
                <?php foreach ($danhsachLophoc as $lop): ?>
                    <option value="<?= htmlspecialchars($lop['malop']) ?>"
                        <?= (($sinhvien['malop'] ?? '') == $lop['malop']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lop['tenlop']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="actions">
            <a class="btn btn-back" href="<?= $basePath ?>/sinhvien">Quay lại</a>
            <button type="submit" class="btn btn-save">Cập nhật</button>
        </div>
    </form>
</div>

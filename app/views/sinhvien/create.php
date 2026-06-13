<div class="container narrow">
    <h2>Thêm sinh viên</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= $basePath ?>/sinhvien/store">
        <div class="form-group">
            <label>Mã sinh viên</label>
            <input type="text" name="mssv" value="<?= htmlspecialchars($old['mssv'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Họ tên</label>
            <input type="text" name="hoten" value="<?= htmlspecialchars($old['hoten'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="sodienthoai" value="<?= htmlspecialchars($old['sodienthoai'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="ngaysinh" value="<?= htmlspecialchars($old['ngaysinh'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Giới tính</label>
            <select name="gioitinh">
                <option value="Nam" <?= (($old['gioitinh'] ?? '') === 'Nam') ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= (($old['gioitinh'] ?? '') === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="diachi"><?= htmlspecialchars($old['diachi'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Lớp</label>
            <select name="malop">
                <option value="">Chưa chọn lớp</option>
                <?php foreach ($danhsachLophoc as $lop): ?>
                    <option value="<?= htmlspecialchars($lop['malop']) ?>"
                        <?= (($old['malop'] ?? '') == $lop['malop']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lop['tenlop']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="actions">
            <a class="btn btn-back" href="<?= $basePath ?>/sinhvien">Quay lại</a>
            <button type="submit" class="btn btn-save">Lưu sinh viên</button>
        </div>
    </form>
</div>

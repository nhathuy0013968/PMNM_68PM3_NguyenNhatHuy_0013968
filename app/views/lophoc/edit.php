<div class="container narrow">
    <h2>Sửa lớp học</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= $basePath ?>/lophoc/update/<?= urlencode($lophoc['malop']) ?>">
        <div class="form-group">
            <label>Mã lớp</label>
            <input type="text" name="malophoc" value="<?= htmlspecialchars($lophoc['malophoc'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Tên lớp</label>
            <input type="text" name="tenlop" value="<?= htmlspecialchars($lophoc['tenlop'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Ghi chú</label>
            <textarea name="ghichu"><?= htmlspecialchars($lophoc['ghichu'] ?? '') ?></textarea>
        </div>

        <div class="actions">
            <a class="btn btn-back" href="<?= $basePath ?>/lophoc">Quay lại</a>
            <button type="submit" class="btn btn-save">Cập nhật</button>
        </div>
    </form>
</div>

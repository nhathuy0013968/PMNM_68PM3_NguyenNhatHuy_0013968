<div class="container narrow">
    <h2>Thêm lớp học</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= $basePath ?>/lophoc/store">
        <div class="form-group">
            <label>Tên lớp</label>
            <input type="text" name="tenlop" value="<?= htmlspecialchars($old['tenlop'] ?? '') ?>" required>
        </div>

        <div class="actions">
            <a class="btn btn-back" href="<?= $basePath ?>/lophoc">Quay lại</a>
            <button type="submit" class="btn btn-save">Lưu lớp học</button>
        </div>
    </form>
</div>

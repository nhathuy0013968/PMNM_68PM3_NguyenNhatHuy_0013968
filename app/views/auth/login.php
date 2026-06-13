<div class="container login-box">
    <h2>Đăng nhập</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= $basePath ?>/auth/login">
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required autofocus>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-save">Đăng nhập</button>
        </div>
    </form>
</div>

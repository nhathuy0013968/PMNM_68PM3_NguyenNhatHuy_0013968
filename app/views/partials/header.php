<div class="header">
    <div class="header-row">
        <div>
            <h1>Hệ thống quản lý sinh viên</h1>
        </div>

        <?php if (empty($hideNav) && isset($_SESSION['user'])): ?>
            <div class="nav">
                <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']) ?></span>
                <a href="<?= BASE_PATH ?>/sinhvien">Sinh viên</a>
                <a href="<?= BASE_PATH ?>/lophoc">Lớp học</a>
                <a href="<?= BASE_PATH ?>/auth/logout">Đăng xuất</a>
            </div>
        <?php endif; ?>
    </div>
</div>

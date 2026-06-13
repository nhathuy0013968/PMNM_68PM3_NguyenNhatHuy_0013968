<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Quản lý sinh viên') ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #111827;
        }

        .header {
            background: #1f2937;
            color: white;
            padding: 18px 40px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 6px 0 0;
            color: #d1d5db;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav a,
        .nav span {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .nav a {
            background: rgba(255, 255, 255, 0.12);
            padding: 8px 10px;
            border-radius: 6px;
        }

        .nav a,
        .btn,
        .action a,
        .page-links a {
            transition: transform 160ms ease, box-shadow 160ms ease, filter 160ms ease, background-color 160ms ease;
        }

        .nav a:hover,
        .btn:hover,
        .action a:hover,
        .page-links a:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 5px 12px rgba(15, 23, 42, 0.22);
        }

        .nav a:active,
        .btn:active,
        .action a:active,
        .page-links a:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(15, 23, 42, 0.18);
        }

        .nav a:focus-visible,
        .btn:focus-visible,
        .action a:focus-visible,
        .page-links a:focus-visible {
            outline: 3px solid #fbbf24;
            outline-offset: 3px;
        }

        .container {
            width: min(1180px, 94%);
            margin: 30px auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            box-sizing: border-box;
        }

        .container.wide {
            width: min(1500px, 96%);
        }

        .table-wrap {
            overflow-x: auto;
        }

        .filter-bar {
            display: grid;
            grid-template-columns: minmax(240px, 1fr) auto auto;
            gap: 10px;
            margin-bottom: 18px;
        }

        .filter-bar input {
            min-width: 0;
        }

        .btn-search {
            background: #0f766e;
        }

        .sort-link {
            color: white;
            text-decoration: none;
        }

        .sort-link:hover {
            text-decoration: underline;
        }

        .flash {
            width: min(1180px, 94%);
            margin: 20px auto -10px;
            padding: 12px 16px;
            border-radius: 6px;
            box-sizing: border-box;
            font-weight: bold;
        }

        .flash.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .flash.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .container.narrow {
            width: min(720px, 92%);
        }

        .container.login-box {
            width: min(440px, 92%);
        }

        h2 {
            margin-top: 0;
            color: #111827;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .nav-actions,
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .actions {
            justify-content: space-between;
            margin-top: 22px;
        }

        .btn {
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            display: inline-block;
        }

        .btn-add,
        .btn-save {
            background: #2563eb;
        }

        .btn-secondary {
            background: #059669;
        }

        .btn-back {
            background: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #374151;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 11px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tr:hover {
            background: #f9fafb;
        }

        .action a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            margin-right: 4px;
            display: inline-block;
        }

        .edit {
            background: #f59e0b;
        }

        .delete {
            background: #dc2626;
        }

        .empty {
            text-align: center;
            padding: 24px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            color: #4b5563;
        }

        .page-links {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .page-links a,
        .page-links span {
            min-width: 36px;
            padding: 8px 10px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            border: 1px solid #d1d5db;
            color: #111827;
            box-sizing: border-box;
        }

        .page-links .active {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
            font-weight: bold;
        }

        @media (max-width: 760px) {
            .header-row,
            .top-bar,
            .pagination {
                align-items: flex-start;
                flex-direction: column;
            }

            .filter-bar {
                grid-template-columns: 1fr;
            }
        }

        .footer {
            width: min(1180px, 94%);
            margin: 0 auto 24px;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php require APP_PATH . '/views/partials/header.php'; ?>
<?php if (!empty($_SESSION['flash'])): ?>
    <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div class="flash <?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>
<?php require $contentView; ?>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>

# PMNM_68PM3_NguyenNhatHuy_0013968

## Thông tin sinh viên

- Họ tên: Nguyễn Nhật Huy
- Lớp: 68PM3
- Mã sinh viên: 0013968

## Môi trường chạy

- Windows
- XAMPP
- Apache
- MariaDB/MySQL
- PHP thuần theo mô hình MVC tự xây dựng

## Cấu hình database

- Database: `qlsv_0013968`
- Host: `127.0.0.1`
- Port MariaDB: `3307`
- User: `root`
- Password: để trống

File cấu hình kết nối:

```text
app/core/ConnectDB.php
```

File SQL tạo database:

```text
database/qlsv.sql
```

## Link truy cập

```text
http://localhost/PMNM_68PM3_NguyenNhatHuy_0013968/sinhvien
```

Nếu chưa đăng nhập, hệ thống tự chuyển về:

```text
http://localhost/PMNM_68PM3_NguyenNhatHuy_0013968/auth/login
```

## Tài khoản mẫu

```text
username: admin
password: 123456
```

## Chức năng đã hoàn thiện

- URL Process/router MVC.
- Login + middleware kiểm tra đăng nhập.
- Core MVC: Controller, ConnectDB, Middleware.
- Layout master + partial header/footer.
- Hiển thị danh sách sinh viên.
- Thêm sinh viên.
- Sửa sinh viên.
- Xóa sinh viên.
- Phân trang danh sách sinh viên.
- CRUD lớp học: danh sách, thêm, sửa, xóa.
- Sinh viên có `masv` là STT tự động và `mssv` là mã sinh viên nhập tay.
- Liên kết sinh viên với lớp học qua trường `malop`.

## Cấu trúc thư mục chính

```text
PMNM_68PM3_NguyenNhatHuy_0013968/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── LophocController.php
│   │   └── SinhvienController.php
│   ├── core/
│   │   ├── ConnectDB.php
│   │   ├── Controller.php
│   │   └── Middleware.php
│   ├── models/
│   │   ├── LophocModel.php
│   │   ├── SinhvienModel.php
│   │   └── UserModel.php
│   └── views/
│       ├── auth/
│       │   └── login.php
│       ├── lophoc/
│       ├── partials/
│       │   ├── footer.php
│       │   ├── header.php
│       │   └── layout.php
│       └── sinhvien/
├── database/
│   └── qlsv.sql
├── public/
│   └── index.php
├── .htaccess
└── README.md
```

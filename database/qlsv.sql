DROP DATABASE IF EXISTS qlsv_0013968;

CREATE DATABASE qlsv_0013968
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE qlsv_0013968;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL
);

CREATE TABLE lophoc (
    malop INT AUTO_INCREMENT PRIMARY KEY,
    malophoc VARCHAR(20) NOT NULL UNIQUE,
    tenlop VARCHAR(100) NOT NULL UNIQUE,
    ghichu VARCHAR(255)
);

CREATE TABLE sinhvien (
    masv INT AUTO_INCREMENT PRIMARY KEY,
    mssv VARCHAR(20) NOT NULL UNIQUE,
    hoten VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    sodienthoai VARCHAR(20),
    ngaysinh DATE,
    gioitinh VARCHAR(10),
    diachi VARCHAR(255),
    malop INT,
    FOREIGN KEY (malop) REFERENCES lophoc(malop)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

INSERT INTO users (username, password, fullname) VALUES
('admin', '123456', 'Nguyễn Nhật Huy');

INSERT INTO lophoc (malophoc, tenlop, ghichu) VALUES
('68PM1', 'Lớp 68PM1', 'Công nghệ phần mềm'),
('68PM2', 'Lớp 68PM2', 'Công nghệ phần mềm'),
('68PM3', 'Lớp 68PM3', 'Công nghệ phần mềm'),
('68PM4', 'Lớp 68PM4', 'Công nghệ phần mềm');

INSERT INTO sinhvien (mssv, hoten, email, sodienthoai, ngaysinh, gioitinh, diachi, malop) VALUES
('SV000001', 'Nguyễn Văn An', 'an@example.com', '0987654321', '2004-01-15', 'Nam', 'Hà Nội', 3),
('SV000002', 'Trần Thị Bình', 'binh@example.com', '0912345678', '2004-05-20', 'Nữ', 'Hải Phòng', 3),
('SV000003', 'Lê Minh Cường', 'cuong@example.com', '0977777777', '2003-09-10', 'Nam', 'Nam Định', 2);

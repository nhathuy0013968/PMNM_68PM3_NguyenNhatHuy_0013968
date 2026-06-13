<?php

class SinhvienModel
{
    private PDO $db;

    public function __construct()
    {
        $connectDB = new ConnectDB();
        $this->db = $connectDB->connect();
    }

    public function getAll(int $limit = 5, int $offset = 0): array
    {
        $sql = "
            SELECT
                sinhvien.masv,
                sinhvien.mssv,
                sinhvien.hoten,
                sinhvien.email,
                sinhvien.sodienthoai,
                sinhvien.ngaysinh,
                sinhvien.gioitinh,
                sinhvien.diachi,
                sinhvien.malop,
                lophoc.tenlop
            FROM sinhvien
            LEFT JOIN lophoc ON sinhvien.malop = lophoc.malop
            ORDER BY sinhvien.masv DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM sinhvien");

        return (int) $stmt->fetchColumn();
    }

    public function getById($masv): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM sinhvien WHERE masv = :masv");
        $stmt->execute([':masv' => $masv]);

        $sinhvien = $stmt->fetch();

        return $sinhvien ?: null;
    }

    public function existsMssv(string $mssv, ?int $excludeMasv = null): bool
    {
        $sql = "SELECT COUNT(*) FROM sinhvien WHERE mssv = :mssv";
        $params = [':mssv' => $mssv];

        if ($excludeMasv !== null) {
            $sql .= " AND masv != :masv";
            $params[':masv'] = $excludeMasv;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function getAllLophoc(): array
    {
        $sql = "SELECT * FROM lophoc ORDER BY malop ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO sinhvien
                (mssv, hoten, email, sodienthoai, ngaysinh, gioitinh, diachi, malop)
            VALUES
                (:mssv, :hoten, :email, :sodienthoai, :ngaysinh, :gioitinh, :diachi, :malop)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':mssv' => $data['mssv'],
            ':hoten' => $data['hoten'],
            ':email' => $data['email'],
            ':sodienthoai' => $data['sodienthoai'] ?: null,
            ':ngaysinh' => $data['ngaysinh'] ?: null,
            ':gioitinh' => $data['gioitinh'] ?: null,
            ':diachi' => $data['diachi'] ?: null,
            ':malop' => $data['malop'] ?: null,
        ]);
    }

    public function update(array $data): bool
    {
        $sql = "
            UPDATE sinhvien
            SET
                mssv = :mssv,
                hoten = :hoten,
                email = :email,
                sodienthoai = :sodienthoai,
                ngaysinh = :ngaysinh,
                gioitinh = :gioitinh,
                diachi = :diachi,
                malop = :malop
            WHERE masv = :masv
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':mssv' => $data['mssv'],
            ':hoten' => $data['hoten'],
            ':email' => $data['email'],
            ':sodienthoai' => $data['sodienthoai'] ?: null,
            ':ngaysinh' => $data['ngaysinh'] ?: null,
            ':gioitinh' => $data['gioitinh'] ?: null,
            ':diachi' => $data['diachi'] ?: null,
            ':malop' => $data['malop'] ?: null,
            ':masv' => $data['masv'],
        ]);
    }

    public function delete($masv): bool
    {
        $stmt = $this->db->prepare("DELETE FROM sinhvien WHERE masv = :masv");

        return $stmt->execute([':masv' => $masv]);
    }
}

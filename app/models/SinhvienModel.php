<?php

class SinhvienModel
{
    private PDO $db;

    public function __construct()
    {
        $connectDB = new ConnectDB();
        $this->db = $connectDB->connect();
    }

    public function getAll(
        int $limit = 5,
        int $offset = 0,
        string $search = '',
        string $sortBy = 'masv',
        string $sortDir = 'ASC'
    ): array {
        $allowedSorts = [
            'masv' => 'sinhvien.masv',
            'mssv' => 'sinhvien.mssv',
            'hoten' => 'sinhvien.hoten',
            'email' => 'sinhvien.email',
            'tenlop' => 'lophoc.tenlop',
        ];
        $sortColumn = $allowedSorts[$sortBy] ?? $allowedSorts['masv'];
        $direction = strtoupper($sortDir) === 'DESC' ? 'DESC' : 'ASC';

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
            WHERE (
                :search = ''
                OR sinhvien.mssv LIKE :keyword
                OR sinhvien.hoten LIKE :keyword
                OR sinhvien.email LIKE :keyword
                OR sinhvien.sodienthoai LIKE :keyword
                OR lophoc.tenlop LIKE :keyword
            )
            ORDER BY {$sortColumn} {$direction}, sinhvien.masv ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':search', $search);
        $stmt->bindValue(':keyword', '%' . $search . '%');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAll(string $search = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM sinhvien
            LEFT JOIN lophoc ON sinhvien.malop = lophoc.malop
            WHERE (
                :search = ''
                OR sinhvien.mssv LIKE :keyword
                OR sinhvien.hoten LIKE :keyword
                OR sinhvien.email LIKE :keyword
                OR sinhvien.sodienthoai LIKE :keyword
                OR lophoc.tenlop LIKE :keyword
            )
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':search' => $search,
            ':keyword' => '%' . $search . '%',
        ]);

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
        return $this->existsField('mssv', $mssv, $excludeMasv);
    }

    public function existsEmail(string $email, ?int $excludeMasv = null): bool
    {
        return $this->existsField('email', $email, $excludeMasv);
    }

    public function getAllLophoc(): array
    {
        $stmt = $this->db->query("SELECT * FROM lophoc ORDER BY malophoc ASC");

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

        return $stmt->execute($this->formParams($data));
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

        $params = $this->formParams($data);
        $params[':masv'] = $data['masv'];

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function delete($masv): bool
    {
        $stmt = $this->db->prepare("DELETE FROM sinhvien WHERE masv = :masv");

        return $stmt->execute([':masv' => $masv]);
    }

    private function existsField(string $field, string $value, ?int $excludeMasv): bool
    {
        $allowedFields = ['mssv', 'email'];

        if (!in_array($field, $allowedFields, true)) {
            return false;
        }

        $sql = "SELECT COUNT(*) FROM sinhvien WHERE {$field} = :value";
        $params = [':value' => $value];

        if ($excludeMasv !== null) {
            $sql .= " AND masv != :masv";
            $params[':masv'] = $excludeMasv;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    private function formParams(array $data): array
    {
        return [
            ':mssv' => $data['mssv'],
            ':hoten' => $data['hoten'],
            ':email' => $data['email'],
            ':sodienthoai' => $data['sodienthoai'] ?: null,
            ':ngaysinh' => $data['ngaysinh'] ?: null,
            ':gioitinh' => $data['gioitinh'] ?: null,
            ':diachi' => $data['diachi'] ?: null,
            ':malop' => $data['malop'] ?: null,
        ];
    }
}

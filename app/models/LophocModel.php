<?php

class LophocModel
{
    private PDO $db;

    public function __construct()
    {
        $connectDB = new ConnectDB();
        $this->db = $connectDB->connect();
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                lophoc.malop,
                lophoc.tenlop,
                COUNT(sinhvien.masv) AS so_sinh_vien
            FROM lophoc
            LEFT JOIN sinhvien ON lophoc.malop = sinhvien.malop
            GROUP BY lophoc.malop, lophoc.tenlop
            ORDER BY lophoc.malop ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($malop): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM lophoc WHERE malop = :malop");
        $stmt->execute([':malop' => $malop]);

        $lophoc = $stmt->fetch();

        return $lophoc ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO lophoc (tenlop) VALUES (:tenlop)");

        return $stmt->execute([':tenlop' => $data['tenlop']]);
    }

    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE lophoc
            SET tenlop = :tenlop
            WHERE malop = :malop
        ");

        return $stmt->execute([
            ':tenlop' => $data['tenlop'],
            ':malop' => $data['malop'],
        ]);
    }

    public function delete($malop): bool
    {
        $stmt = $this->db->prepare("DELETE FROM lophoc WHERE malop = :malop");

        return $stmt->execute([':malop' => $malop]);
    }
}
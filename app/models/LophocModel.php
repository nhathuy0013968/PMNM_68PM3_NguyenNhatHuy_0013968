<?php

class LophocModel
{
    private PDO $db;

    public function __construct()
    {
        $connectDB = new ConnectDB();
        $this->db = $connectDB->connect();
    }

    public function getAll(int $limit = 5, int $offset = 0, string $search = ''): array
    {
        $sql = "
            SELECT
                lophoc.malop,
                lophoc.malophoc,
                lophoc.tenlop,
                lophoc.ghichu,
                COUNT(sinhvien.masv) AS so_sinh_vien
            FROM lophoc
            LEFT JOIN sinhvien ON lophoc.malop = sinhvien.malop
            WHERE (
                :search = ''
                OR lophoc.malophoc LIKE :keyword
                OR lophoc.tenlop LIKE :keyword
                OR lophoc.ghichu LIKE :keyword
            )
            GROUP BY lophoc.malop, lophoc.malophoc, lophoc.tenlop, lophoc.ghichu
            ORDER BY lophoc.malop ASC
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
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM lophoc
            WHERE (
                :search = ''
                OR malophoc LIKE :keyword
                OR tenlop LIKE :keyword
                OR ghichu LIKE :keyword
            )
        ");
        $stmt->execute([
            ':search' => $search,
            ':keyword' => '%' . $search . '%',
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function getById($malop): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM lophoc WHERE malop = :malop");
        $stmt->execute([':malop' => $malop]);

        $lophoc = $stmt->fetch();

        return $lophoc ?: null;
    }

    public function existsMalophoc(string $malophoc, ?int $excludeMalop = null): bool
    {
        return $this->existsField('malophoc', $malophoc, $excludeMalop);
    }

    public function existsTenlop(string $tenlop, ?int $excludeMalop = null): bool
    {
        return $this->existsField('tenlop', $tenlop, $excludeMalop);
    }

    public function hasStudents($malop): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM sinhvien WHERE malop = :malop");
        $stmt->execute([':malop' => $malop]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO lophoc (malophoc, tenlop, ghichu)
            VALUES (:malophoc, :tenlop, :ghichu)
        ");

        return $stmt->execute([
            ':malophoc' => $data['malophoc'],
            ':tenlop' => $data['tenlop'],
            ':ghichu' => $data['ghichu'] ?: null,
        ]);
    }

    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE lophoc
            SET malophoc = :malophoc, tenlop = :tenlop, ghichu = :ghichu
            WHERE malop = :malop
        ");

        return $stmt->execute([
            ':malophoc' => $data['malophoc'],
            ':tenlop' => $data['tenlop'],
            ':ghichu' => $data['ghichu'] ?: null,
            ':malop' => $data['malop'],
        ]);
    }

    public function delete($malop): bool
    {
        $stmt = $this->db->prepare("DELETE FROM lophoc WHERE malop = :malop");

        return $stmt->execute([':malop' => $malop]);
    }

    private function existsField(string $field, string $value, ?int $excludeMalop): bool
    {
        $allowedFields = ['malophoc', 'tenlop'];

        if (!in_array($field, $allowedFields, true)) {
            return false;
        }

        $sql = "SELECT COUNT(*) FROM lophoc WHERE LOWER({$field}) = LOWER(:value)";
        $params = [':value' => $value];

        if ($excludeMalop !== null) {
            $sql .= " AND malop != :malop";
            $params[':malop'] = $excludeMalop;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }
}

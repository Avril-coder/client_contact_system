<?php

class Client {
    private $conn;
    private $table = 'clients';

    public $id;
    public $name;
    public $code;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new client
    public function create() {
        $sql = "INSERT INTO {$this->table} (name, code) VALUES (:name, :code)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':code', $this->code);

        return $stmt->execute();
    }

    // Generate a client code (e.g., 3 uppercase + 3 digits)
    public function generateCode() {
        $letters = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3));
        $numbers = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
        $this->code = $letters . $numbers;
    }

    // Get all clients
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all clients with count of linked contacts
    public function getAllWithContactCount() {
        $sql = "SELECT c.id, c.name, c.code, 
                (SELECT COUNT(*) FROM client_contact cc WHERE cc.client_id = c.id) AS contact_count
                FROM {$this->table} c
                ORDER BY c.name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


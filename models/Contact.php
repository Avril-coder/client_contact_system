<?php

class Contact {
    private $conn;
    public $id;
    public $name;
    public $surname;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
    $sql = "INSERT INTO contacts (name, surname, email) VALUES (:name, :surname, :email)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':surname', $this->surname);
    $stmt->bindParam(':email', $this->email);
    return $stmt->execute();
}


   public function getAll() {
    $sql = "SELECT con.*, 
                   (SELECT COUNT(*) FROM client_contact cc WHERE cc.contact_id = con.id) AS client_count 
            FROM contacts con 
            ORDER BY con.surname ASC, con.name ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function isEmailUnique($email) {
    $sql = "SELECT COUNT(*) as count FROM contacts WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] == 0;
}

}

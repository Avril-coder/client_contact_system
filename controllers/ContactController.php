<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Contact.php';

class ContactController {
    private $db;
    private $contact;

    public function __construct() {
        $this->db = (new Database())->connect();
        $this->contact = new Contact($this->db);
    }

    public function handleCreate($postData) {
        if (!empty($postData['name']) && !empty($postData['surname']) && !empty($postData['email'])) {
            if (!$this->contact->isEmailUnique($postData['email'])) {
                header("Location: ../views/contact_list.php?error=email_exists");
                exit;
            }

            $this->contact->name = htmlspecialchars($postData['name']);
            $this->contact->surname = htmlspecialchars($postData['surname']);
            $this->contact->email = htmlspecialchars($postData['email']);

            if ($this->contact->create()) {
                header("Location: ../views/contact_list.php?success=created");
                exit;
            } else {
                header("Location: ../views/contact_list.php?error=1");
                exit;
            }
        } else {
            header("Location: ../views/contact_list.php?error=missing_fields");
            exit;
        }
    }
}

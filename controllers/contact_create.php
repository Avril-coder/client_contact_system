<?php
require_once 'ContactController.php';

$controller = new ContactController();
$controller->handleCreate($_POST);

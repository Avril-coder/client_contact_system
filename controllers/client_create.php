<?php
require_once 'ClientController.php';

$controller = new ClientController();
$controller->handleCreate($_POST);

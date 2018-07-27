<?php
if (!isset($_POST['action'])) {
	error("L'action n'est pas définie");
}

$action = $_POST['action'];
$data = $_POST['data'];
if ($action == "save_transaction") {
	$this->saveTransaction($data);
}

if ($action == "delete_transaction") {
    $this->deleteTransaction($data);
}

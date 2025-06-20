<?php
require_once __DIR__ . '/../models/customermodel.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $model = new CustomerModel();
    $model->saveContact($name, $email, $message);
    header('Location: index.php');
}
?>
<?php
require_once __DIR__ . '/../models/customermodel.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $model = new CustomerModel();
    $model->createAppointment($name, $email, $service, $date);
    header('Location: index.php');
}
?>
<?php
require_once __DIR__ . '/../includes/db.php';
class CustomerModel {
    public function createAppointment($name, $email, $service, $date){
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO appointments (name, email, service, date, status) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $service, $date, 'Scheduled']);
    }
    public function saveContact($name, $email, $message){
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $message]);
    }
}
?>
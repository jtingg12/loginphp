<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$db = "starkit";
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
    // 加密密码
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user_manual (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if($stmt->execute()){
        echo json_encode(['success'=>true,'message'=>"User stored successfully"]);
    } else {
        echo json_encode(['success'=>false,'message'=>"Failed to store user"]);
    }

    $stmt->close();
} else {
    echo json_encode(['success'=>false,'message'=>"Email and password required"]);
}

$conn->close();
?>

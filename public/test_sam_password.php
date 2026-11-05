<?php

require_once __DIR__ . "/../config/database.php";

$email = "sam@nzmega.co.nz";
$password = "Sam123456";

$sql = "SELECT password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Sam's account was not found.";
    exit;
}

if (password_verify($password, $user["password"])) {
    echo "SUCCESS: Sam's password is correct!";
} else {
    echo "FAILED: Sam's password does not match.";
}

?>
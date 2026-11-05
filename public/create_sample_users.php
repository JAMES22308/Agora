
<?php

require_once __DIR__ . "/../config/database.php";

// Sample accounts
$users = [

    [
        "Sam Colo",
        "sam@nzmega.co.nz",
        "Sam123456",
        "business_admin",
        1
    ],

    [
        "James Kennedy",
        "james@nzmega.co.nz",
        "James123456",
        "seller",
        1
    ],

    [
        "Lisa Schmitt",
        "lisa@foxbutcher.co.nz",
        "Lisa123456",
        "buyer",
        2
    ],

    [
        "Simon Lau",
        "simon@agora.co.nz",
        "Simon123456",
        "agora_admin",
        null
    ]

];

$sql = "INSERT INTO users
        (full_name, email, password, role, business_id, is_active)
        VALUES (?, ?, ?, ?, ?, 1)";

$stmt = $conn->prepare($sql);

foreach ($users as $user) {

    $passwordHash = password_hash($user[2], PASSWORD_DEFAULT);

    $stmt->execute([
        $user[0],
        $user[1],
        $passwordHash,
        $user[3],
        $user[4]
    ]);

}

echo "Sample accounts created successfully!";

?>

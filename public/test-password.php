<?php

$password = 'Alex123456';

$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br>";
echo "New Hash: " . $hash;

?>
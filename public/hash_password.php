<?php

$password = "Sam123456";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo $hash;

?>
<?php

$password = "AgoraTest123!";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Agora Password Hash Generator</h2>";

echo "<p>Original password: " . htmlspecialchars($password) . "</p>";

echo "<p>Generated hash:</p>";

echo "<textarea rows='4' cols='80' readonly>";
echo htmlspecialchars($hash);
echo "</textarea>";

?>
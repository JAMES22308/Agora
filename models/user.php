
<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Find a user using their email address
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    // Find a user using their ID
    public function findById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a user's profile
    public function updateProfile($userId, $fullName, $email)
    {
        $sql = "UPDATE users
                SET full_name = ?, email = ?
                WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $fullName,
            $email,
            $userId
        ]);
    }

    
    // Register a new user
    public function create($fullName, $email, $passwordHash, $role)
    {
        $sql = "INSERT INTO users
                (full_name, email, password, role)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $fullName,
            $email,
            $passwordHash,
            $role
        ]);
    }


}

?>

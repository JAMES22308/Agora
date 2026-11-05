
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

    
    // Get sellers belonging to a particular business
    public function getSellersByBusiness($businessId)
    {
        $sql = "SELECT user_id, full_name, email, is_active
                FROM users
                WHERE business_id = ?
                AND role = 'seller'
                ORDER BY user_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$businessId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a seller account for a business
    public function createSellerForBusiness(
        $businessId,
        $fullName,
        $email,
        $passwordHash
    ) {
        $sql = "INSERT INTO users
                (business_id, full_name, email, password, role, is_active)
                VALUES (?, ?, ?, ?, 'seller', 1)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $businessId,
            $fullName,
            $email,
            $passwordHash
        ]);
    }

    // Activate or deactivate a seller belonging to a business
    public function updateSellerStatus(
        $userId,
        $businessId,
        $isActive
    ) {
        $sql = "UPDATE users
                SET is_active = ?
                WHERE user_id = ?
                AND business_id = ?
                AND role = 'seller'";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $isActive,
            $userId,
            $businessId
        ]);
    }

    
    // Get buyers belonging to a particular business
    public function getBuyersByBusiness($businessId)
    {
        $sql = "SELECT user_id, full_name, email, is_active
                FROM users
                WHERE business_id = ?
                AND role = 'buyer'
                ORDER BY user_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$businessId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a buyer account for a business
    public function createBuyerForBusiness(
        $businessId,
        $fullName,
        $email,
        $passwordHash
    ) {
        $sql = "INSERT INTO users
                (business_id, full_name, email, password, role, is_active)
                VALUES (?, ?, ?, ?, 'buyer', 1)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $businessId,
            $fullName,
            $email,
            $passwordHash
        ]);
    }

    // Activate or deactivate a buyer belonging to a business
    public function updateBuyerStatus(
        $userId,
        $businessId,
        $isActive
    ) {
        $sql = "UPDATE users
                SET is_active = ?
                WHERE user_id = ?
                AND business_id = ?
                AND role = 'buyer'";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $isActive,
            $userId,
            $businessId
        ]);
    }




}

?>

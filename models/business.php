
<?php

class Business
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all businesses
    public function getAll()
    {
        $sql = "SELECT * FROM businesses ORDER BY business_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a business using its ID
    public function findById($businessId)
    {
        $sql = "SELECT * FROM businesses WHERE business_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$businessId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new business
    public function create($businessName)
    {
        $sql = "INSERT INTO businesses (business_name) VALUES (?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$businessName]);
    }

    // Update business information
    public function update($businessId, $businessName)
    {
        $sql = "UPDATE businesses
                SET business_name = ?
                WHERE business_id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$businessName, $businessId]);
    }
}

?>

<?php
require_once 'database.php';

class StaffHandler {
    private $conn;
    private $table_name = "staff";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllStaff() {
        $query = "SELECT StaffID, CONCAT(First_name, ' ', Last_name) as FullName, First_name, Last_name, Role FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }

    public function getTechnicians() {
        $query = "SELECT StaffID, CONCAT(First_name, ' ', Last_name) as FullName 
                FROM " . $this->table_name . " 
                WHERE Role = 'Technician'";
        $result = $this->conn->query($query);
        return $result;
    }

    public function addStaff($first_name, $last_name, $role) {
        $query = "INSERT INTO " . $this->table_name . " (First_name, Last_name, Role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $first_name, $last_name, $role);
        
        if($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function updateStaff($id, $first_name, $last_name, $role) {
        $query = "UPDATE " . $this->table_name . " SET First_name=?, Last_name=?, Role=? WHERE StaffID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $first_name, $last_name, $role, $id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteStaff($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE StaffID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getStaffById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE StaffID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?> 
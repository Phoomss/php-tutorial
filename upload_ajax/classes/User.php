<?php
class User {
    private $conn;
    private $table_name = "users_upload";

    public $id;
    public $name;
    public $email;
    public $picture;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, picture=:picture";
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->picture=htmlspecialchars(strip_tags($this->picture));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":picture", $this->picture);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->picture = $row['picture'];
    }

    function update() {
        // Read the current picture for comparison
        $this->readOne();
        $old_picture = $this->picture;

        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, picture = :picture WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->picture=htmlspecialchars(strip_tags($this->picture));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':picture', $this->picture);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            // Delete the old picture if a new one is provided and it's different
            if($this->picture && $this->picture != $old_picture && file_exists("uploads/" . $old_picture)) {
                unlink("uploads/" . $old_picture);
            }
            return true;
        }
        return false;
    }

    function delete() {
        // Get the picture to delete
        $this->readOne();
        $old_picture = $this->picture;

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            // Delete the picture file
            if($old_picture && file_exists("uploads/" . $old_picture)) {
                unlink("uploads/" . $old_picture);
            }
            return true;
        }
        return false;
    }
}
?>

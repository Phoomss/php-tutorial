<?php

require_once '../config/Database.php';
require_once '../backend/User.php';
$database = new Database();
$db = $database->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->id = $_POST['id'];
    $user->role = $_POST['role'];

    $query = "UPDATE users SET role = :role WHERE id = :id";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $user->id);
    $stmt->bindParam(':role', $user->role);

    if ($stmt->execute()) {
        echo "<p class='alert alert-success'>User role updated successfully.</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to update user role.</p>";
    }
}

// Get user data for display
$query = "SELECT * FROM users";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Role</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Update User Role</h2>
        <form action="update_role.php" method="POST">
            <div class="form-group">
                <label for="id">Select User</label>
                <select name="id" class="form-control" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>">
                            <?php echo $user['username'] . ' (' . $user['role'] . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Select New Role</label>
                <select name="role" class="form-control" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
</body>

</html>
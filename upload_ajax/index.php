<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD with Image Upload</title>
</head>
<body>
    <h2>CRUD Application with Image Upload</h2>
    <form id="userForm" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="picture">Picture:</label>
        <input type="file" name="picture" id="picture" accept="image/*"><br>
        <img id="imagePreview" src="" alt="Image Preview" style="display:none; width: 100px; height: auto;"><br>
        <button type="submit">Save</button>
    </form>

    <h3>User List</h3>
    <table id="userTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script src="js/scripts.js"></script>
</body>
</html>

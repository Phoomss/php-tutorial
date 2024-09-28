<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form id="registerForm" method="POST" action="register_action.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#registerForm").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url: './apis/register_action.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>

</body>

</html>
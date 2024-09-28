<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form id="loginForm">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#loginForm").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: './apis/login_action.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        if (res.role === "admin") {
                            window.location.href = "./frontend/admin/admin_dashboard.php";
                        } else if (res.role === "user") {
                            window.location.href = "./frontend/user/user_dashboard.php";
                        } else if (res.role === "manager") {
                            window.location.href = "manager_dashboard.php";
                        } else {
                            window.location.href = "index.php";
                        }
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert("An error occurred while processing your request.");
                }
            });
        });
    });
</script>

</body>
</html>

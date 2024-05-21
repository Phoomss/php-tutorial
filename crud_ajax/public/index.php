<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD Application</title>
</head>

<body>
    <h1>CRUD Application</h1>
    <div id="userInfo"></div>
    <button id="logoutButton">Logout</button>
    <form id="recordForm">
        <input type="hidden" id="recordId">
        <input type="text" id="name" placeholder="Name" required>
        <input type="email" id="email" placeholder="Email" required>
        <button type="submit">Submit</button>
    </form>
    <table id="recordsTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script src="script.js"></script>
</body>

</html>
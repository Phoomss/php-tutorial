document.addEventListener('DOMContentLoaded', function () {
    // Login form handling
    if (document.getElementById('loginForm')) {
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;

            fetch('../ajax/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username: username, password: password })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loginMessage').innerText = data.message;
                    if (data.message === "Login successful.") {
                        window.location.href = 'index.php';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loginMessage').innerText = 'An error occurred. Please try again.';
                });
        });
    }

    // Register form handling
    if (document.getElementById('registerForm')) {
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;
            let role = document.getElementById('role').value;

            fetch('../ajax/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username: username, password: password, role: role })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('registerMessage').innerText = data.message;
                    if (data.message === "Registration successful.") {
                        window.location.href = 'login.php';
                    }
                });
        });
    }

    // Logout button handling
    if (document.getElementById('logoutButton')) {
        document.getElementById('logoutButton').addEventListener('click', function () {
            fetch('../ajax/logout.php')
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    window.location.href = 'login.php';
                });
        });
    }

    // Record form handling
    if (document.getElementById('recordForm')) {
        checkSession();
        fetchRecords();

        document.getElementById('recordForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let id = document.getElementById('recordId').value;
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;

            if (id) {
                updateRecord(id, name, email);
            } else {
                createRecord(name, email);
            }
        });
    }
});

function checkSession() {
    fetch('../ajax/checkSession.php')
        .then(response => response.json())
        .then(data => {
            if (!data.logged_in) {
                window.location.href = 'login.php';
            } else {
                document.getElementById('userInfo').innerText = `Logged in as ${data.username} (${data.role})`;
                if (data.role !== 'admin') {
                    document.getElementById('recordForm').style.display = 'none';
                }
            }
        });
}

function fetchRecords() {
    fetch('../ajax/read.php')
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('#recordsTable tbody');
            tbody.innerHTML = '';
            if (data && data.records) { // ตรวจสอบว่า data.records มีค่าหรือไม่
                data.records.forEach(record => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${record.name}</td>
                        <td>${record.email}</td>
                        <td>
                            <button onclick="editRecord(${record.id}, '${record.name}', '${record.email}')">Edit</button>
                            <button onclick="deleteRecord(${record.id})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                console.error('No records found');
            }
        })
        .catch(error => {
            console.error('Error fetching records:', error);
        });
}


function createRecord(name, email) {
    fetch('../ajax/create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: name, email: email })
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchRecords();
        });
}

function updateRecord(id, name, email) {
    fetch('../ajax/update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id, name: name, email: email })
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchRecords();
            document.getElementById('recordId').value = '';
        });
}

function deleteRecord(id) {
    fetch('../ajax/delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchRecords();
        });
}

function editRecord(id, name, email) {
    document.getElementById('recordId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
}

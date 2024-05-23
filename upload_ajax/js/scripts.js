document.addEventListener("DOMContentLoaded", function() {
    loadUsers();

    document.getElementById("picture").addEventListener("change", function() {
        previewImage(this);
    });

    document.getElementById("userForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadUsers();
                this.reset();
                document.getElementById("imagePreview").style.display = 'none';
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

function loadUsers() {
    fetch('read.php')
    .then(response => response.json())
    .then(data => {
        let tableBody = document.querySelector("#userTable tbody");
        tableBody.innerHTML = "";
        data.forEach(user => {
            let row = tableBody.insertRow();
            row.insertCell(0).innerText = user.name;
            row.insertCell(1).innerText = user.email;
            let imgCell = row.insertCell(2);
            if (user.picture) {
                let img = document.createElement("img");
                img.src = "uploads/" + user.picture;
                img.width = 50;
                imgCell.appendChild(img);
            }
            let actionsCell = row.insertCell(3);
            let editBtn = document.createElement("button");
            editBtn.innerText = "Edit";
            editBtn.onclick = () => editUser(user.id);
            actionsCell.appendChild(editBtn);

            let deleteBtn = document.createElement("button");
            deleteBtn.innerText = "Delete";
            deleteBtn.onclick = () => deleteUser(user.id);
            actionsCell.appendChild(deleteBtn);
        });
    })
    .catch(error => console.error('Error:', error));
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

function editUser(id) {
    fetch(`read.php?id=${id}`)
    .then(response => response.json())
    .then(user => {
        document.getElementById("id").value = user.id;
        document.getElementById("name").value = user.name;
        document.getElementById("email").value = user.email;
        if (user.picture) {
            document.getElementById('imagePreview').src = "uploads/" + user.picture;
            document.getElementById('imagePreview').style.display = 'block';
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }

        let existingPictureInput = document.querySelector("input[name='existing_picture']");
        if (existingPictureInput) {
            existingPictureInput.value = user.picture;
        } else {
            existingPictureInput = document.createElement("input");
            existingPictureInput.type = "hidden";
            existingPictureInput.name = "existing_picture";
            existingPictureInput.value = user.picture;
            document.getElementById("userForm").appendChild(existingPictureInput);
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteUser(id) {
    if (confirm("Are you sure to delete this user?")) {
        fetch(`delete.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadUsers();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

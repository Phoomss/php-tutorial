<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <?php
    if (isset($_GET['id'])) {
        require_once '../Backend/config/connect_db.php';
        $stmt = $connect->prepare("SELECT * FROM tbl_member WHERE id=?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index
        if ($stmt->rowCount() < 1) {
            header('Location: ../frontend/index.php');
            exit();
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-me-4">
                <h4>ฟอร์มแก้ไขข้อมูล</h4>
                <form action="../Backend/formEdit_db.php" method="post">
                    <div class="mb-1">
                        <label for="name" class="col-sm-2 col-form-label"> ชื่อ : </label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" required value="<?= $row['name']; ?>" minlength="3">
                        </div>
                    </div>
                    <div class="mb-1">
                        <label for="name" class="col-sm-2 col-form-label"> นามสกุล : </label>
                        <div class="col-sm-10">
                            <input type="text" name="surname" class="form-control" required value="<?= $row['surname']; ?>" minlength="3">
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
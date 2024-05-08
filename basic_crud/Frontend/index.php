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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>รายการสมาชิก <a href="formAdd.php" class="btn btn-info">เพิ่มข้อมูล</a></h3>
                <table class="table table-striped table-hover table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="40%">ชื่อ</th>
                            <th width="45%">นามสกุล</th>
                            <th width="5%">แก้ไข</th>
                            <th width="5%">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../Backend/config/connect_db.php';
                        $stmt = $connect->prepare("SELECT*FROM tbl_member");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach ($result as $result) {
                        ?>
                            <tr>
                                <td><?= $result['id'] ?></td>
                                <td><?= $result['name'] ?></td>
                                <td><?= $result['surname']; ?></td>
                                <td><a href="formEdit.php?id=<?= $result['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                                <td><a href="../Backend/del.php?id=<?= $result['id']; ?>" class="btn btn-danger btn-sm delete-btn" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ลบ</a></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
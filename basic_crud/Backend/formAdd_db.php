<?php
require_once './config/connect_db.php';

// ถ้ามีค่าส่งมาจากฟอร์ม
if (isset($_POST['name']) && isset($_POST['surname'])) {
    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $name = $_POST['name'];
    $surname = $_POST['surname'];

    // sql insert
    $stmt = $connect->prepare("INSERT INTO tbl_member (name,surname) VALUES(:name,:surname)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
    $result = $stmt->execute();

    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    if ($result) {
        echo '<script>
        setTimeout(function(){
            swal({
                title: "เพิ่มข้อมูลสำเร็จ",
                type: "success"
            },function(){
                window.location = "../frontend/index.php";
            });
        });
        </script>';
    } else {
        echo '<script>
        setTimeout(function() {
         swal({
             title: "เกิดข้อผิดพลาด",
             type: "error"
         }, function() {
             window.location = "../frontend/index.php"; //หน้าที่ต้องการให้กระโดดไป
         });
       });
   </script>';
    }
    $connect = null;
}

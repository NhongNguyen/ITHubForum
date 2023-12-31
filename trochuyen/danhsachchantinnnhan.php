<?php 
  include_once '../config/Database.php';
  include_once '../class/NguoiDung.php';
  include "auth.php";
  $database = new Database();
  $db = $database->getConnection();
  $tblNguoiDung = new NguoiDung($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="img/n.jpg" type="image/x-icon">
    <title>Danh sách chặn tin nhắn | ITHub</title>
    <style>
      * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
      }
      h1,h2,h3,h4,h5,h6{
        font-weight: bold;
      }
      .container {
        margin: auto;
        font-family: "Poppins", Arial, san-serif;
        line-height: 1.4;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f9f9f9;
        height: 100%;
      }
      .card {
        background: #fff;
        background-size: contain;
        border-radius: 10px;
        box-shadow: 0 10px 30px -5px rgba(60, 60, 60, 0.2);
        text-align: center;
        padding: 30px;
      }
      .card img {
        background-color: #dddfe6;
        height: 120px;
        width: 120px;
        border-radius: 50%;
        margin: auto auto 15px;
        display: block;
      }
      .card h1 {
        font-size: 22px;
        margin: 10px auto 0;
        letter-spacing: 1px;
      }
      .card h2 {
        margin: auto;
        color: #b1b6c6;
        font-weight: 300;
        font-size: 14px;
      }
      .navbar{
        height: 60px;
        padding-left:30px;
      }
      .fa-arrow-circle-left{
        font-size: 25px;
      }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <a href="tinnhan.php"><i class="fas fa-arrow-circle-left"></i></a> &nbsp;&nbsp;&nbsp;
          <li class="breadcrumb-item"><a href="tinnhan.php">Trò chuyện</a></li>
          <li class="breadcrumb-item active" aria-current="page"><b>Danh sách chặn tin nhắn</b></li>
        </ol>
      </nav>
    </div>
  </nav>

  <div class="container mt-5 pt-3 bg-white">
    <div class="row p-2">
      <?php
        $findSql = "
        SELECT * FROM `tblnguoidung` s
        JOIN `tblchantinnhan` t ON t.nguoiBiChan = s.taiKhoan
        WHERE t.nguoiChan = '".$_SESSION['taiKhoan']."';
        ";
        $result = $db->query($findSql);
        $count = $result->num_rows;
        if (mysqli_num_rows($result) > 0) {
          while ($data = mysqli_fetch_assoc($result)) {
            $friendUsername = $data['taiKhoan'];
            $friendEmail = $data['email'];
            $tableName = "ithub";
            $ifExists = false;
            $target = $friendUsername."_".$taiKhoan;
            $findTable = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'ithub' AND TABLE_NAME = '$target'";
            $findResult = $db->query($findTable);
            

            $folder = "../image/".$data['anhDaiDien'];
              if ($count >= 3) {
                $colClass = 'col-lg-4';
              } elseif ($count == 2) {
                  $colClass = 'col-lg-6';
              } else{
                $colClass = 'col-lg-12';
              }
              $room = $friendUsername.'_'.$taiKhoan;
              echo "
                <div class='$colClass p-3'>
                    <div class='card'>
                        <img src='$folder' alt='User'>
                        <h1 class='font-weight-bold mb-1'>$friendUsername</h1>
                        <h2 class= 'mb-1'><i class='fa fa-user'></i>Thành viên</h2>
                        <h2><i class='fas fa-envelope'></i> $friendEmail</h2>
                        <div class='container bg-white'>
                            <a href='../nguoidung/trangbanbe.php?taiKhoanBanBe=$friendUsername' type='button' class='btn btn-lg btn-outline-danger btn-rounded m-1 mt-3 fw-bold' data-mdb-ripple-color='dark'>Thông tin</a>
                            <a href='chantinnhan.php?id=$room&nguoiChan=$taiKhoan&nguoiBiChan=$friendUsername&hanhDong=huyChan' type='button' title='Hủy chặn tin nhắn' class='btn btn-lg btn-danger btn-floating m-1 mt-3'><i class='fa fa-ban mt-3' aria-hidden='true'></i></a>
                        </div>
                    </div>
                </div>";
          }
        }
      ?>
    </div>
</div>


</body>
</html>

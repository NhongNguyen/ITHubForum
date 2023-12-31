<?php ob_start(); ?>
<style>
        .search-container {
            position: relative;
            max-width: 66%; /* Điều chỉnh chiều rộng tối đa */
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-sizing: border-box;
        }
        .search-input:focus-visible{
            border: 1px solid #ccc!important;
        }
        .navbar-toggler {
            position: absolute;
            right: 15px; /* Điều chỉnh vị trí theo nhu cầu của bạn */
            top: 15px; /* Điều chỉnh vị trí theo nhu cầu của bạn */
        }
        .search-button {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px 14px;
            /* background-color: #ffc107; */
            color: black;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .search-button:hover{
            background-color: rgba(174, 172, 169, 0.1);
            color: black;
        }
        .nav-item2{
            color: black;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 600;
            margin: 0 10px;
        }
        
        .navbar-nav2{
            display: flex;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
            padding-right: 0;
            padding-left: 0;
            
        }
        .nav-item2:hover{
            color: #ffc107;
        }
        /* Responsive design */
        @media (max-width: 600px) {
            .navbar-expand-lg .navbar-collapse {
                position: fixed;
                background-color: white; /* Màu nền của navbar toggle */
                left: -100%; /* Di chuyển nó ra ngoài màn hình bên trái */
                height:100vh;
                width: 250px;
                transition: left 0.1s ease-in-out; /* Tạo hiệu ứng di chuyển mượt mà */
                z-index: 1000; /* Đảm bảo nó ở trên trang web */
                padding: 10px;
            }
            
            .navbar-collapse.show {
                left: 0; 
            }
            
            .res-moblie{
                display: flex;
                justify-content: center;
            }
            .navbar-toggler {
                position: absolute!important;
                top: -205%;
                right: 85%;
            }
            .notification-item:hover {
                background-color: rgba(0, 0, 0, 0.15);
            }
            .search-container {
            position: relative;
            max-width: 100%; /* Điều chỉnh chiều rộng tối đa */
            padding-bottom: 10px;
        }
        }
        
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 col-xs-12 padding-center-logo res-moblie">
            <a href="http://localhost/ITHub/trangchu.php" class="text-decoration-none re-icon" style="color: black;">
                <h1 style="font-weight: bold;" class="m-0"><span class="text-warning">IT</span>HUB</h1>
            </a>
        </div>
        <div class="col-lg-7 col-xs-12 ">
            <form action="http://localhost/ITHub/timkiem/ketquatimkiem.php" method="get">
                <div class="search-container">
                    <input type="text" name="search" class="search-input" value="<?php if(isset($search))  echo $search?>" placeholder="Tìm tài liệu, bài viết...">
                    <a  class="search-button " ><button type="submit" style="color: initial;background: initial;border: initial;" class="fa fa-search"></button></button></a>
                </div>
            </form>
        </div>
        <div class="col-lg-2 col-md-2 " style="text-align:right" >
            
            <?php 
                $currentPage = basename($_SERVER['PHP_SELF']);
                if($currentPage == 'trangchu.php') {
                    $path = '../ITHub/';
                } else {
                    $path = '../';
                }
                if($currentPage == 'trangchu.php') {
                    $_SESSION['currentPage'] = 'trangchu.php';
                } else {
                    $_SESSION['currentPage'] = '';
                }
                if(!isset($_SESSION['hoatdong']))
                {
                    if($currentPage == 'trangchu.php') {
                        echo '<a class="btn btn-warning" href="'.$path.'nguoidung/dangnhap.php">Đăng nhập</a>';
                    } else {
                        echo '<a class="btn btn-warning" href="'.$path.'nguoidung/dangnhap.php">Đăng nhập</a>';
                    }
                   
                }
                else{
                    
                    if(!isset($tblNguoiDung)){
                        include_once $path."class/NguoiDung.php";
                        $tblNguoiDung  = new NguoiDung($db);
                    }

                    $tblNguoiDung->taiKhoan = $_SESSION['taiKhoan'];
                    $userInfo = $tblNguoiDung->getUserInfoByTaiKhoan($_SESSION['taiKhoan']);
                    if ($userInfo !== null) {
                        $anhDaiDien = $userInfo['anhDaiDien'];
                        $taiKhoan = $userInfo['taiKhoan'];
                    } else {
                        $anhDaiDien = 'user.jpg';
                    }
                    
                    $color = 'green';
                    if(isset($_POST['submitTrangThai'])){
                        if($tblNguoiDung->changeTrangThaiHoatDong()) {
                           
                        }
                        else{
                            $msgHoatDong = 'Cập nhật trạng thái không thành công';
                        }
                    }
                    
                    $trangThaiResult = $tblNguoiDung->getTrangThaiHoatDong();
                    if ($trangThaiResult !== null) {
                        
                        if ($trangThaiResult == 'ban') {
                            $trangThai = 'Hoạt động';
                            $color = 'red';
                        } elseif ($trangThaiResult == 'hoatdong') {
                            $trangThai = 'Bận';
                            $color = 'green';
                        }
                    }
                    if(isset($_POST['dangxuat'])){
                        $tblNguoiDung->logOut();
                    }
                ?>
                <div class="d-flex" style="float:right;">
                    <!-- start message -->
                    <a href="<?php echo $path?>trochuyen/tinnhan.php" role="button" aria-expanded="false" class="text-black text-decoration-none" id="tinnhan" style="display: flex; justify-content: center; flex-direction: column; position: relative;">
                        <span class="badge bg-danger rounded-pill countTN" style="position: absolute; top: 9px; left: -7px; width: 15px; height: 15px; padding: 3px 1px; font-size: 8px; display:none">
                        </span>
                        <span class="fa fa-envelope text-black" aria-hidden="true" style="font-size: 18px;"></span>
                    </a>
                    <!-- end message -->
                    <!-- start thongbao -->
                    <div class="nav-item dropdown px-3" style="line-height: 45px; display: flex">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="text-black text-decoration-none" id="thongbao" style="display: flex; justify-content: center; flex-direction: column; position: relative;">
                            <span class="badge bg-danger rounded-pill count" style="position: absolute; top: 9px; left: -7px; width: 15px; height: 15px; padding: 3px 1px; font-size: 8px; display:none">
                            </span>
                            <span class="fa fa-bell" aria-hidden="true" style="font-size: 18px;"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end navbar-right" id="notification" style="max-height: 87vh; overflow-y: auto; overflow-x: hidden;">
      
                        </ul>
                    </div>
                    <!-- end thong bao -->
                    <div class="nav-item dropdown">
                        <!-- start avt -->
                        <div style="cursor: pointer;"  class="dropdown">
                            <div  data-bs-toggle="dropdown" >
                                <?php 
                                    if(isset($color))
                                    //----------------------------------------------------------------------
                                    echo ' 
                                    <div class="d-flex" >
                                        <div class="m-1" style=" font-weight: bold; font-size: 20px;line-height: 38px;" ><span style="border-left: 3px solid black; height: 10px; padding-right: 15px;"></span> </span>'.$taiKhoan.'&nbsp;</div>
                                        <img style="width: 45px; height: 45px; object-fit: cover;border: 3px solid '.$color.';" class="user-avatar rounded-circle" src="'.$path.'image/'.$anhDaiDien.'" alt="User Avatar">
                                    </div>
                                    '
                                    //----------------------------------------------------------------------
                                ?>
                            </div>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?php echo $path;?>nguoidung/trangcanhan.php">Trang cá nhân</a>
                                </li>
                                <li>
                                    <form method="post">
                                    <button type="submit" name="submitTrangThai" class="dropdown-item" href="#">
                                        <?php 
                                            if(isset($trangThai))
                                            echo $trangThai;
                                        ?>
                                    </button>

                                        <input type="text" name="trangThai" value="<?php echo $trangThai ?>" hidden>
                                    </form>
                                </li>
                                <?php 
                                    if(isset($msgHoatDong))
                                        echo '<li style="color:red">'.$msgHoatDong.'</li>'
                                ?>
                                <li><a class="dropdown-item" href="<?php echo $path; ?>nguoidung/doimatkhau.php">Đổi mật khẩu</a></li>
                                <li>
                                    <form method="post">
                                        <button type="submit" name="dangxuat" class="dropdown-item" href="#">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                            
                    </div>
                </div>
                <?php  }?>
            
        </div>
        
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container">
<div class="container-fluid">
    <div class="row border-top px-xl-5 pt-2">
        <div style="font-size: 20px;" class="col-lg-10  offset-lg-1" >
            <nav class="navbar navbar-expand-lg py-3 py-lg-0 px-0">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex" id="navbarCollapse">
                    <div class="navbar-nav navbar-nav2 m-auto">
                        <a href="<?php echo $path?>trangchu.php" class="nav-item nav-item2 nav-link">Trang chủ</a>
                        <a href="<?php echo $path?>tailieu/danhsachtailieu.php" class="nav-item nav-item2 nav-link">Tài liệu</a>
                        <a href="<?php echo $path?>diendan/chudebaiviet.php" class="nav-item nav-item2 nav-link">Diễn đàn</a>
                        <?php 
                            if(isset($_SESSION['taiKhoan'])){
                                $conn = new mysqli('localhost','root',"","ithub");
                                $queryRole = "SELECT quyen FROM `tblnguoidung` WHERE taiKhoan = '".$_SESSION['taiKhoan']."'";
                                $resultRole = $conn->query($queryRole);
                                $rowRole = $resultRole -> fetch_assoc();
                                if($rowRole['quyen'] == 'quantrivien'){
                                    echo '<a href="'.$path.'quantri/baivietkiemduyet.php" class="nav-item nav-item2 nav-link">Quản trị</a>';   
                                }
                                
                            }
                            
                        ?>
                        <a href="#" class="nav-item nav-item2 nav-link">Bài tập cá nhân</a>
                        
                        <a href="<?php echo $path?>trochuyen/tinnhan.php" class="nav-item nav-item2 nav-link">Liên hệ</a>
                    </div>
                    
                </div>
                
            </nav>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        var screenWidth = $(window).width();

        if (screenWidth <= 600) {
            $('.navbar-toggler').click(function () {
                $('.navbar-collapse').toggleClass('show');
            });

            $(document).on('click', function (e) {
                // Kiểm tra xem người dùng đã ấn vào 35% màn hình phía bên phải
                if (e.pageX / screenWidth > 0.65) {
                    $('.navbar-collapse').removeClass('show');
                }
            });
        }
    });

    $("#notification").on("click", "li a", function(event) {
    event.preventDefault();
    var linkHref = $(this).attr("href");
    var endLink = $(this).attr("href");
    
    linkHref = linkHref.replace(/^(\.\.\/|\.\/ITHub\/)/, '');

    $.ajax({
        url: "../notification/fetch.php",
        method: "POST",
        data: { linkHref: linkHref },
        success: function() {
            window.location.href = endLink;
        }
    });
});

</script>
<?php
    if(isset( $_SESSION['taiKhoan'])) {
        $_SESSION['room'] = "quantrivien_" . $_SESSION['taiKhoan'];
    }
?>

<script>
  document.getElementById('tinnhan').addEventListener('click', function() {
    var room = "<?php echo $_SESSION['room']; ?>";
    console.log(room);
  });
</script>


<div style="min-height: 500px;" class="container">
    <div class="row">

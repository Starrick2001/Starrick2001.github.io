<?php
session_start();
include_once "connect.php";
$url = "../";
$email = $_GET["profile_email"];
$sql_get_profile_data = "SELECT email, name, avatarUrl, birth FROM member WHERE email = '$email'";
$result = $connect->query($sql_get_profile_data);
if ($result->num_rows > 0)
    $profile_data = $result->fetch_assoc();
else {
    echo "Không tìm thấy hồ sơ.";
    exit;
}
?>

<head>
    <title>Trang cá nhân</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var url = "../";
    </script>
    <script src="signin-signout.js"></script>
    <script src="comment.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo/Logo1.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="../style.css">
    <style>
        #editInformation .form-floating:focus-within {
            z-index: 2;
        }

        #editInformation input#floatingname {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        #editInformation input#floatingBirth {
            margin-bottom: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        #editInformation input#floatingPassword {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        #changePassword .form-floating:focus-within {
            z-index: 2;
        }

        #changePassword input#floatingOldPassword {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        #changePassword input#floatingNewPassword {
            margin-bottom: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        #changePassword input#floatingReEnterNewPassword {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#save-btn").click(function() {
                var password = $('#floatingPassword').val();
                var name = $("#floatingName").val();
                if (name == "")
                    alert("Tên không được bỏ trống.");
                else {
                    var birth = $("#floatingBirth").val();
                    if (birth == "")
                        alert("Ngày sinh không được bỏ trống.");
                    else {
                        $.ajax({
                            method: "POST",
                            url: url + "function/edit-information.php",
                            data: {
                                name: name,
                                birth: birth,
                                password: password
                            },
                            success: function(data) {
                                if (data == "Yes") {
                                    $("#editInformation").hide();
                                    location.reload();
                                }
                                if (data == "No") {
                                    alert("Sai mật khẩu.");
                                }
                            }
                        })
                    }
                }
            });

            $("#change-password-btn").click(function() {
                var oldPassword = $('#floatingOldPassword').val();
                var password = $("#floatingNewPassword").val();
                var reenterPassword = $('#floatingReEnterNewPassword').val();
                if (password == "" || reenterPassword == "")
                    alert("Mật khẩu không được bỏ trống");
                else
                if (password != reenterPassword)
                    alert("Mật khẩu không khớp");
                else {
                    $.ajax({
                        method: "POST",
                        url: url + "function/change-password.php",
                        data: {
                            oldPassword: oldPassword,
                            password: password
                        },
                        success: function(data) {
                            if (data == "Yes") {
                                $("#change-password-btn").hide();
                                location.reload();
                            }
                            if (data == "No") {
                                alert("Sai mật khẩu.");
                            }
                        }
                    });
                }
            });
        });
    </script>
</head>

<body>

    <!-- navbar -->
    <?php
    $setVisibleCreatePostBtn = true;
    include $url . "themes/navbar.php";
    ?>
    <!-- navbar -->


    <!-- sử dụng main bao hết nội dung web lại -->
    <main class="container pt-2">
        <!-- bao phần nội dung chính -->
        <div class="row shadow m-3 p-2">
            <div class="col-md-2 position-relative">
                <img src="<?php echo $url . $profile_data["avatarUrl"] ?>" class="w-100">
                <div class="position-absolute top-0 ">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="avatar" class="btn-outline-secondary btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-card-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z"></path>
                            </svg>
                        </label>
                        <input type="file" name="avatar" onchange="form.submit()" id="avatar" class="d-none" />
                    </form>
                </div>
            </div>
            <div class="col-md-10">
                <h2 class="mt-3"><?php echo $profile_data["name"]; ?></h2>
                <h5>Địa chỉ email: <?php echo $profile_data["email"]; ?> </h5>
                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInformation">Sửa thông tin</a>
                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePassword">Đổi mật khẩu</a>

                <?php
                if (isset($_FILES["avatar"]["name"])) {
                    include_once "connect.php";
                    $target_dir = "../img/avatar/";
                    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
                    $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    if ($imgFileType == "jpg" || $imgFileType == "png" || $imgFileType == "jpeg") {
                        if ($_FILES["avatar"]["size"] < 500000) {
                            $imgUrl = "img/avatar/" . basename($_FILES["avatar"]["name"]);
                            $sql = "UPDATE member SET avatarUrl = '" . $imgUrl . "' WHERE email = '" . $_SESSION["email"] . "'";
                            mysqli_query($connect, $sql);
                            move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                        } else echo "<script> alert('Kích thước ảnh quá lớn');</script>";
                    } else
                        echo "<script> alert('Chỉ hỗ trợ định dạng JPEG, PNG, JPG.');</script>";
                    echo "<script>window.location.href = '';</script>";
                } ?>

            </div>
        </div>
        <!-- Bài viết -->
        <h1 class="text-center">Danh sách các bài viết</h1>
        <?php
        include_once $url . "function/connect.php";
        $name = $profile_data["name"];
        $query = "SELECT * FROM posts WHERE author = '" . $name . " - " . $email . "'";
        $result = mysqli_query($connect, $query);
        ?>

        <!-- Khởi tạo row -->
        <div class="row mb-2">
            <?php
            $tmp = 1;
            while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
                <div class="col-lg">
                    <div class="row shadow rounded m-3 p-2">
                        <div class="col-md-4">
                            <img src="<?php echo $url . $post["imgUrl"]; ?>" class="w-100 align-middle" alt="" />
                        </div>
                        <div class="col-md-8">
                            <!--                            Content-->
                            <h6 class="pt-2"><?php echo $post["title"]; ?></h6>
                            <p class="content">
                                <?php
                                if (strlen($post["content"]) > 300)
                                    $content =  mb_substr($post["content"], 0, 300) . "...";
                                else $content = $post["content"];
                                echo $content;
                                ?>
                            </p>
                            <p class="text-end">
                                <a class="btn btn-primary" href="<?php echo $url . "function/post.php?post_id=" . $post["post_id"]; ?>">Xem thêm</a>
                            </p>
                        </div>
                        <p class="author text-end">
                            <?php echo "Người viết: " . $post["author"]; ?>
                        </p>
                    </div>
                </div>
                <?php
                // Cứ 2 bài post sẽ kết thúc row và tạo row mới
                if ($tmp == 2) {
                    $tmp = 1;
                ?>
        </div>
        <div class="row mb-2">
    <?php
                } else {
                    $tmp += 1;
                }
            }
    ?>
    <!-- Bài viết -->
    <!-- kết thúc nội dung chính -->
    <div class="modal" id="editInformation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thông tin</h5>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingName" value="<?php echo $profile_data["name"]; ?>" name="name">
                        <label for="floatingName">Tên</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="floatingBirth" value="<?php echo $profile_data["birth"]; ?>">
                        <label for="floatingBirth">Ngày sinh</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Nhập mật khẩu</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-bs-toggle="modal" id="save-btn">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal" id="changePassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đổi mật khẩu</h5>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingOldPassword" placeholder="Password">
                        <label for="floatingPassword">Nhập mật khẩu cũ</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingNewPassword" placeholder="Password">
                        <label for="floatingPassword">Nhập mật khẩu mới</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingReEnterNewPassword" placeholder="Password">
                        <label for="floatingPassword">Nhập lại mật khẩu mớI</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-bs-toggle="modal" id="change-password-btn">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
    </main>
    <!-- sử dụng main bao hết nội dung web lại -->
    <?php
    include_once $url . "themes/backtotopbtn.php";
    include_once $url . "themes/modal.php";
    ?>
</body>
<?php
include "connection.php";
include "library_author.php";

if (isset($_POST['register'])) { // mengecek apakah form variabelnya ada isinya
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // isi varibel dengan mengambil data email pada form
    $password = $_POST['password']; // isi variabel dengan mengambil data password pada form
    $confirm_password = $_POST['password_confirmation'];

    if ($_POST['password'] != $_POST['password_confirmation']) {
        echo '<script type="text/javascript">alert("Password and Confirm Password did not match !");</script>';
    } else {
        $file_name = $_FILES['photo']['name'];
        $file_size = $_FILES['photo']['size'];
        $file_type = $_FILES['photo']['type'];
        $tmp = $_FILES['photo']['tmp_name'];
        $path = "assets/img/" . $file_name;
        if ($file_size < 2048000 and ($file_type == 'image/jpeg' or $file_type == 'image/png')) {
            move_uploaded_file($tmp, $path);
            $image   = $file_name;
            try {
                $libReg = new LibraryAuthor();
                $libReg->add_author($name, $email, $password, $image);
                echo '<script type="text/javascript">';
                echo 'alert("Register Success!!");';
                echo 'if(alert){location.replace("login.php");}';
                echo '</script>';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            echo '<span style="color:red"><b><u><i>Max size : 2Mb</i></u></b></span>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Register</title>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h1 class="text-center">Register</h1>
                <hr>
                <form method="POST" action="" enctype="multipart/form-data" onSubmit="return validasi(this);">
                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">Name *</label>
                        <div class="col-md-6">
                            <input type="name" name="name" id="name" class="form-control" autocomplete="name" autofocus required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label text-md-right">Email *</label>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control" autocomplete="email" autofocus required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 col-form-label text-md-right">Password *</label>
                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" name="password" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-3 col-form-label text-md-right">Confirm Password *</label>
                        <div class="col-md-6">
                            <input type="password" id="password-confirm" class="form-control" name="password_confirmation" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="photo" class="col-md-3 col-form-label text-md-right">Photo *</label>
                        <div class="col-md-6">
                            <div class="custom-file">
                                <label for="photo" class="custom-file-label col-md-12">
                                    <i class="fa fa-cloud-upload"></i> Select Photo
                                </label>
                                <input type="file" name="photo" id="photo" accept="image/*" class="custom-file-input" required>
                                <script type="application/javascript">
                                    $('#photo').change(function() {
                                        var i = $(this).prev('label').clone();
                                        var file = $('#photo')[0].files[0].name;
                                        $(this).prev('label').text(file);
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0 text-center">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary" name="register" value="register">Register</button>
                            <a href="login.php" class="btn btn-success ml-4">Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function validasi(form) {
            if (form.password.value.length < 8) {
                alert("Password at least 8 character");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
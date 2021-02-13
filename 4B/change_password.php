<?php
include "connection.php";
include "library_author.php";

if (isset($_POST['change'])) { // mengecek apakah form variabelnya ada isinya
    $email = $_POST['email']; // isi varibel dengan mengambil data email pada form
    $new_password = $_POST['new_password']; // isi variabel dengan mengambil data password pada form
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        echo '<script type="text/javascript">alert("New Password and Confirm Password did not match !");</script>';
    } else {
        $libUser = new LibraryAuthor();
        $user = $libUser->get_by_email($email);
        if ($user) {
            $id = $user['id'];
            $name = $user['name'];
            $email_db = $user['email'];
            $photo = $user['image'];

            try {
                $libUser->update($id, $name, $photo, $email, $new_password);
                echo '<script type="text/javascript">';
                echo 'alert("Edit Password Success!!");';
                echo 'if(alert){location.replace("index.php");}';
                echo '</script>';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            echo '<script type="text/javascript">alert("Your email not been registered !");</script>';
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
    <title>Change Password</title>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h1 class="text-center">Change Password</h1>
                <hr>
                <form method="POST" action="" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new_password" class="col-md-4 col-form-label text-md-right">New Password *</label>

                        <div class="col-md-6">
                            <input id="new_password" type="password" class="form-control " name="new_password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirm_password" class="col-md-4 col-form-label text-md-right">Confirm Password *</label>

                        <div class="col-md-6">
                            <input id="confirm_password" type="password" class="form-control " name="confirm_password" required autocomplete="current-password">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" name="change" value="change">
                                Update
                            </button>
                            <a href="login.php" class="btn btn-success ml-4">Login</a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <p>Not registered?
                                <a href="register.php">Register</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
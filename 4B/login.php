<?php
include "connection.php";

$loginFailed = false;

if (!isset($_SESSION['name']) == 0) { // cek session apakah kosong(belum login) maka alihkan ke index.php
    header('Location: index.php');
}

if (isset($_POST['login'])) { // mengecek apakah form variabelnya ada isinya
    $email = $_POST['email']; // isi varibel dengan mengambil data email pada form
    $password = $_POST['password']; // isi variabel dengan mengambil data password pada form


    try {
        $sql = "SELECT * FROM author WHERE email = :email AND password = :password"; // buat queri select
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute(); // jalankan query

        $datas = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $datas['id'];
        $name = $datas['name'];
        $photo = $datas['image'];

        $count = $stmt->rowCount(); // mengecek row
        if ($count == 1) { // jika rownya ada 
            $_SESSION['name'] = $name; // set sesion dengan variabel name 
            $_SESSION['id'] = $id;
            $_SESSION['photo'] = $photo;
            header("Location: index.php"); // lempar variabel ke tampilan index.php
            return;
        } else {
            $loginFailed = true;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <?php if ($loginFailed) {
                    echo "<div class='alert alert-danger text-center'>";
                    echo "Email and Password did not match!";
                    echo "</div>";
                }
                $loginFailed = false;
                ?>

                <h1 class="text-center">Login</h1>
                <hr>
                <form method="POST" action="" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            <a href="change_password.php">Forgot Password ?</a>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" name="login" value="login">
                                Login
                            </button>
                            <a href="register.php" class="btn btn-success ml-4">Register</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
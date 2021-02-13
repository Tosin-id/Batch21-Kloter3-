<?php
include "connection.php";
include "library_category.php";
include "library_author.php";

$idUser = $_SESSION['id'];
$libUser = new LibraryAuthor();
$user = $libUser->get_by_id($idUser);
$name = $user['name'];
$image = $user['photo'];
$email = $user['email'];
$password = $user['password'];

if (isset($_POST['edit_profile'])) {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];

    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        // echo '<img src="data:image/jpg;base64,' . base64_encode($image) . '" width="400px">';
    }

    try {
        $libUser = new LibraryAuthor();
        $add = $libUser->update($idUser, $newName, $image, $newEmail, $password);
        echo '<script type="text/javascript">';
        echo 'alert("Edit Profil Success!!");';
        echo 'if(alert){location.replace("index.php");}';
        echo '</script>';
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Edit Profile</title>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h1 class="text-center">Edit Profile</h1>
                <hr>
                <form method="POST" action="" enctype="multipart/form-data" onSubmit="return validasi(this);">

                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input type="name" name="name" id="name" class="form-control" autocomplete="name" required value="<?php echo $name ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control" autocomplete="email" required value="<?php echo $email ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="image" class="col-md-3 col-form-label text-md-right">Change Picture</label>
                        <div class="col-md-6 ">
                            <div class="form-control">
                                <input type="file" name="image" id="image" accept="image/*" class="form-control-file" onchange="preview_image(event)">
                            </div>
                            <!-- <img id="output_image" src="" /> -->
                            <img id="output_image" src="data:image/jpeg;base64, <?php echo base64_encode($image); ?>" . width="400px">
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <a href="change_password.php">Change Password ?</a>
                    </div>

                    <hr>
                    <div class="form-group row mb-0 text-center">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary" name="edit_profile" value="edit_profile">Change</button>
                            <a href="index.php" class="btn btn-success ml-3">Home</a>
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

        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <style>
        body {
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }

        #wrapper {
            text-align: center;
            margin: 0 auto;
            padding: 0px;
            width: 995px;
        }

        #output_image {
            max-width: 400px;
            max-height: 800px;
            padding: 10px;
        }
    </style>
</body>

</html>
<?php
include "connection.php";
include "library_article.php";
include "library_author.php";
include "library_category.php";

try {

    $user_id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $photo = $_SESSION['photo'];

    $libArticle = new LibraryArticle();

    $libCategory = new LibraryCategory();
    $categories = $libCategory->show();
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_SESSION['name']) == 0) { /* Halaman ini tidak dapat diakses jika belum ada yang login */
    header('Location: login.php');
}

if (isset($_POST['add'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = "assets/img/" . $image;
        move_uploaded_file($tmp, $path);
    } else {
        $image = "";
    }
    date_default_timezone_set('Asia/Jakarta');
    $created_at = date("Y-m-d H:i:s");
    $category_id = $libCategory->get_id($_POST['category']);
    $catID = $category_id[0];

    try {
        // echo $title . "<br>";
        // echo $content . "<br>";
        // echo $image . "<br>";
        // echo $created_at . "<br>";
        // echo $user_id . "<br>";
        // echo $catID . "<br>";
        $libArticle->add_article($title, $content, $image, $created_at, $user_id, $catID);
        echo '<script type="text/javascript">';
        echo 'alert("Add Article Success!!");';
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Article</title>

    <!-- Bootstrap CSS file -->
    <link href="lib/bootstrap-3.0.3/css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link href="lib/bootstrap-3.0.3/css/bootstrap-theme.min.css" rel="stylesheet" /> -->
    <link href="blog.css" rel="stylesheet" />

</head>
<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>

    <!-- Header -->
    <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand">Article</a>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                <form class="navbar-form navbar-right" role="search">
                    <a href="logout.php" class="btn btn-default">Logout</a>
                </form>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Body -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3">
                <form method="POST" action="" enctype="multipart/form-data" onSubmit="return validasi(this);">
                    <h2 class="text-center">Add Article</h2>
                    <div class="form-group row">
                        <div class=".col-xs-6 .col-sm-4">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class=".col-xs-6 .col-sm-4">
                            <label for="image">Change Picture</label>
                            <div class="form-control">
                                <input type="file" name="image" id="image" accept="image/*" class="form-control-file" onchange="preview_image(event)">
                            </div>
                            <img id="output_image" class="img-responsive" style="max-width: 400px;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class=".col-xs-6 .col-sm-4">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control" rows="5" placeholder="Add content..."></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class=".col-xs-6 .col-sm-4">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category['name'] ?>"><?php echo $category['name'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" name="add" value="add">Submit</button>
                            <a href="index.php" class="btn btn-success ml-3">Home</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <hr />
            <p class="text-center">Copyright &copy; Tosin 2021. All rights reserved.</p>
        </div>
    </footer>
</body>

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
        /* margin: 0 auto; */
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


<!-- Jquery and Bootstrap Script files -->
<script src="lib/jquery-2.0.3.min.js"></script>
<script src="lib/bootstrap-3.0.3/js/bootstrap.min.js"></script>

</html>
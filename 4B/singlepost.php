<?php
include "connection.php";
include "library_article.php";
include "library_author.php";
include "library_category.php";

if (isset($_SESSION['name']) == 0) { /* Halaman ini tidak dapat diakses jika belum ada yang login */
    header('Location: login.php');
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$photo = $_SESSION['photo'];

try {
    $libArticle = new LibraryArticle();
    $contents = $libArticle->get_by_id($_GET['id']);

    foreach ($contents as $content) {
        $ttl = $content['title'];
    }

    $libCategory = new LibraryCategory();
    $categories = $libCategory->show();

    $libAuthors = new LibraryAuthor();
    $authors = $libAuthors->show();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A Bootstrap Blog Template">
    <meta name="author" content="Vijaya Anand">

    <title><?php echo $ttl ?></title>

    <!-- Bootstrap CSS file -->
    <link href="lib/bootstrap-3.0.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="lib/bootstrap-3.0.3/css/bootstrap-theme.min.css" rel="stylesheet" />
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
        <div class="row">
            <div class="col-md-8">
                <?php
                if (isset($_GET['id'])) {
                    foreach ($contents as $content) {
                        $title = $content['title'];
                        $text = $content['content'];
                        $image = $content['image'];
                        $created_at = $content['created_at'];
                        $author = $content['author'];
                        $category = $content['category'];

                ?>
                        <!-- <h1>Latest Posts</h1> -->
                        <article>
                            <h2><a href="singlepost.php?id=<?php echo $id ?>"><?php echo $title ?></a></h2>

                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <?php
                                    $category_id = $libCategory->get_id($category);
                                    $catID = $category_id[0];
                                    ?>
                                    &nbsp;&nbsp;<span class="glyphicon glyphicon-bookmark"></span> <a href="index.php?category=<?php echo $catID ?>"><?php echo $category ?></a>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <?php if ($author == $name) { ?>
                                        &nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span> <a href="edit.php?id=<?php echo $id ?>">Edit</a>
                                        &nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span> <a href="delete.php?id=<?php echo $id ?>">Delete</a>
                                    <?php } ?>
                                    &nbsp;&nbsp;<span class="glyphicon glyphicon-time"></span> <?php echo $created_at ?>
                                </div>
                            </div>

                            <hr>

                            <img src="assets/img/<?php echo $image ?>" class="img-responsive" style="max-width: 400px;">

                            <br />

                            <p><?php echo $text ?></p>

                            <hr>
                        </article>
                <?php }
                } ?>

                <!-- <ul class="pager">
                    <li class="previous"><a href="#">&larr; Previous</a></li>
                    <li class="next"><a href="#">Next &rarr;</a></li>
                </ul> -->

            </div>
            <div class="col-md-4">

                <!-- Latest Posts -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Latest Posts</h4>
                    </div>
                    <ul class="list-group">
                        <?php
                        $values = $libArticle->show();
                        foreach ($values as $value) { ?>
                            <li class="list-group-item"><a href="singlepost.php?id=<?php echo  $value['id'] ?>"><?php echo  $value['title'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Categories</h4>
                    </div>
                    <ul class="list-group">
                        <?php foreach ($categories as $category) { ?>
                            <li class="list-group-item"><a href="index.php?category=<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Author -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Author</h4>
                    </div>
                    <ul class="list-group">
                        <?php foreach ($authors as $auth) { ?>
                            <li class="list-group-item"><a href="index.php?author=<?php echo $auth['id'] ?>"><?php echo $auth['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

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

    <!-- Jquery and Bootstrap Script files -->
    <script src="lib/jquery-2.0.3.min.js"></script>
    <script src="lib/bootstrap-3.0.3/js/bootstrap.min.js"></script>
</body>

</html>
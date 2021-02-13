<?php
include "connection.php";
include "library.php";
include "library_author.php";

if (isset($_SESSION['name']) == 0) { /* Halaman ini tidak dapat diakses jika belum ada yang login */
    header('Location: login.php');
}

$id = $_SESSION['id'];

try {
    $libPost = new Library();
    $posts = $libPost->show();
    // foreach ($posts as $post) {
    //     $id = $post['id'] . "\t";
    //     $name = $post['name'] . "\t";
    //     $photo = $post['photo'] . "\t";
    //     '<img src="data:image/jpeg;base64,' . base64_encode($photo) . '" width="200px">' . "\t";
    //     $content = $post['content'] . "\t";
    //     $image = $post['image'];
    //     '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" width="200px">' . "\t";
    //     $id_user = $post['id_user'] . "\t";
    // }
    $libUser = new LibraryAuthor();
    $user = $libUser->get_by_id($id);
    $picture = $user['photo'];
    $name = $user['name'];
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <script>
        document.getElementsByTagName("html")[0].className += " js";
    </script>
    <title>Profil</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top mb-4">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <strong><a class="navbar-brand" href="index.php" data-toggle="tooltip" data-placement="bottom" title="WaysGram" style="font-size: 40px;">WaysGram</a></strong>
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item">
                        <a href="add_content.php" class="btn btn-primary ml-3 mr-3">Add Content</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($picture) . '" width="50px" height="50px" class="rounded-circle">' ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbardrop">
                            <a class="dropdown-item" href="index.php">Home</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php" style="color: orangered;">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid text-center">
        <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($picture) . '" width="200px" height="200px" class="rounded-circle">' ?>
        <h3 class="mt-2 mb-2">
            <strong>
                <?php echo $name ?>
            </strong>
        </h3>
        <a href="edit_profile.php" class="btn btn-outline-secondary ml-3 mr-3">Edit Profile</a>
    </div>
    <hr>
    <div class="container d-flex justify-content-center">
        <div class="card-columns">
            <?php
            foreach ($posts as $post) {
                $idPost = $post['id'];
                $name = $post['name'];
                $photo = $post['photo'];
                '<img src="data:image/jpeg;base64,' . base64_encode($photo) . '" width="200px">';
                $content = $post['content'];
                $image = $post['image'];
                '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" width="200px">';
                $id_user = $post['id_user'];
            ?>
                <?php if ($id == $id_user) { ?>
                    <div class="card">
                        <div class="btn-action text-center">
                            <a href="edit.php?idPost=<?php echo $idPost ?>" class="btn btn-primary d-inline-block">Edit</a>
                            <a href="delete.php?idPost=<?php echo $idPost ?>" class="btn btn-danger ml-3" onclick="return confirm('Are you sure to delete this content?')">Delete</a>
                        </div>
                        <img class="card-mg-top img-fluid rounded" src="data:image/jpeg;base64, <?php echo base64_encode($image); ?>" width="400px" height="300px">
                        <div class="card-body">
                            <figcaption class="figure-caption"><?php echo $content ?></figcaption>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <a href="#" class="cd-top text-replace js-cd-top"></a>
    <script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>

</html>
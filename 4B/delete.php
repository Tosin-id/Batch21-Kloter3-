<?php
include "connection.php";
include "library_article.php";

$idArticle =  $_GET['id'];
try {
    $libArticle = new LibraryArticle();
    $libArticle->delete($idArticle);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        alert("Article was deleted !!");
        if (alert) {
            location.replace("index.php");
        }
    </script>
    <title>Delete</title>
</head>

<body>

</body>

</html>
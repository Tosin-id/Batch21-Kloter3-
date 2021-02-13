<?php

use function PHPSTORM_META\type;

include "connection.php";
include "library_article.php";
include "library_author.php";

$arrID = array();
$no = 1;

try {

    if (isset($_SESSION['id'])) {
        $arr = $_SESSION['id'];
        if (gettype($arr) == 'array') {
            foreach ($arr as $value) {
                array_push($arrID, $value);
            }
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 0;
        }

        unset($_SESSION['id']);
        if (!in_array($id, $arrID)) {
            $id != 0 ? array_push($arrID, $id) : $id = 0;
        }
    } else {
        $id != 0 ? array_push($arrID, $id) : $id = 0;
    }

    $_SESSION['id'] = $arrID;
    // var_dump($_SESSION['id']);
    foreach ($arrID as $field => $value) {
        $id_data[$field] = $value;
    }
    // var_dump(json_encode($id_data));

    $libCycle = new LibraryArticle();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script type="text/javascript">
        let id_data = <?php echo json_encode($id_data) ?>;
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top mb-4">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <h1 class="navbar-brand" data-toggle="tooltip" data-placement="bottom" title="WaysGram" style="font-size: 40px;"><strong>DW Bike</strong></h1>
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item">
                        <a href="index.php" onclick="tes()" class="btn btn-primary ml-3 mr-3">Home</a>
                    </li>
                    <li class="nav-item dropdown ml-4">
                        <a style="font-size:22px" class="nav-link dropdown-toggle" href="#" id="navbardrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong></strong><?php echo $_SESSION['name'];  ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbardrop">
                            <a class="dropdown-item" href="logout.php" style="color: orangered;">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Order List</h2>
        <?php if (count($arrID) > 0) { ?>
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sepeda</th>
                        <th>Nama</th>
                        <th>Merk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($arrID as $id_cycle) {
                        $cycles = $libCycle->get_by_id($id_cycle);
                        foreach ($cycles as $cycle) {
                            $id = $cycle['Id'] ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <div id="id_cycle">
                                        <?php echo $no; ?>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div id="sepeda">
                                        <img src="assets/img/<?php echo $cycle['Image'] ?>" style="max-width: 100px;">
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div id="nama">
                                        <strong><?php echo $cycle['Nama']; ?></strong>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div id="merk">
                                        <?php echo $cycle['Merk']; ?>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div id=<?php echo "harga" . strval($no) ?>>
                                        <?php echo  $cycle['Harga']; ?>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <input class="form-control" type="number" id=<?php echo "jumlah" . strval($no) ?> name=<?php echo $cycle['Id'] ?> min=0 oninput="validity.valid||(value='');" onchange="change(id,name)" value="1" style="width: 5em">
                                </td>
                                <td style="vertical-align: middle;">
                                    <div id=<?php echo "subtotal" . strval($no) ?>>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;" class="text-center">
                                    <button class=" btn btn-warning" id=<?php echo $cycle['Id'] ?> name=<?php echo $cycle['Id'] ?> onclick="hapus(id,name)">Hapus</button>
                                </td>
                            </tr>
                    <?php $no++;
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align:right">
                            <strong>Total</strong>
                        </td>
                        <td>
                            <div id="total"></div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-success" onclick="bayar()">Bayar</button>
                            <a href="index.php" class=" btn btn-secondary ml-3">Tambah</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <?php
        } else {
            echo "<div class='alert alert-danger text-center'>";
            echo "No Data !";
            echo "</div>";
        } ?>
    </div>
</body>
<script type="text/javascript">
    const formatRupiah = (money) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }

    let id_harga = "harga";
    let id_qty = "jumlah";
    let id_sub = "subtotal";
    let total = 0;

    for (let id in id_data) {
        id++;
        id_harga = "harga" + id
        id_qty = "jumlah" + id
        id_sub = "subtotal" + id

        let harga = parseInt(document.getElementById(id_harga).innerText);
        let qty = sessionStorage.getItem(document.getElementById(id_qty).name);
        if (qty === null) {
            qty = parseInt(document.getElementById(id_qty).value);
        }

        let subtotal = harga * qty;
        document.getElementById(id_qty).value = qty;
        document.getElementById(id_sub).innerText = formatRupiah(subtotal);
        document.getElementById(id_harga).innerText = formatRupiah(harga);

        total += subtotal;
    }
    document.getElementById("total").innerText = formatRupiah(total);


    function change(id, name) {
        for (let ids in id_data) {
            ids++;
            id_harga = "harga" + ids
            id_qty = "jumlah" + ids
            id_sub = "subtotal" + ids

            if (id === id_qty) {
                let harga = numberFormat(document.getElementById(id_harga).innerText);
                let qty = parseInt(document.getElementById(id_qty).value);
                let subtotal = harga * qty;

                document.getElementById(id_sub).innerText = formatRupiah(subtotal);
                sessionStorage.setItem(name, qty);
            }
        }
        calculateTotal();
    }

    function calculateTotal() {
        let totalHarga = 0;
        for (let ids in id_data) {
            ids++;
            id_sub = "subtotal" + ids
            let subtotal = numberFormat(document.getElementById(id_sub).innerText);
            totalHarga += subtotal;
        }
        document.getElementById("total").innerText = formatRupiah(totalHarga);
    }

    function numberFormat(angka) {
        var num = parseInt(angka.slice(3).split('.').join(''));
        return num;
    }

    function bayar() {
        alert("Silahkan bayar sejumlah " + document.getElementById("total").innerText);
    }

    function hapus(id, name) {
        sessionStorage.removeItem(name);
        window.location.href = "delete.php?id=" + id;
    }
</script>
<script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="assets/js/main.js"></script>
<script src="assets/js/popper.js"></script>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.js"></script>

</html>
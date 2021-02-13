<?php
session_start();
$host = "localhost"; // Nama hostnya
$username = "root"; // Username
$password = ""; // Password (Isi jika menggunakan password)
$database = "db_article"; // Nama databasenya

try {
    // Koneksi ke MySQL dengan PDO
    $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password);
    // set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // tampilkan pesan kesalahan jika koneksi gagal
    print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
    die();
}

<?php
$server = "localhost";
$user = "root";
$password = "";
$db_name = "tgs_7";

// Koneksi
$conn = mysqli_connect($server, $user, $password, $db_name);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM daftar_konser WHERE PersonID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $delete = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($delete) {
        header("Location: tabel.php");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak valid.";
}
?>
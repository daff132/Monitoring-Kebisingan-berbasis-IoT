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

// Ambil ID dari URL
$id = $_GET['id'] ?? null;

if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM daftar_konser WHERE PersonID = $id");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data tidak ditemukan.");
    }

    // Jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['user'];
        $email = $_POST['email'];
        $date = $_POST['alamat'];
        $tanggal_konser = $_POST['tanggal_konser'] ?? null;
        $umur = $_POST['umur'] ?? null;

        $update = mysqli_query($conn, "UPDATE daftar_konser SET 
            Name='$nama', 
            email='$email', 
            alamat='$date',
            tanggal_konser='$tanggal_konser',
            umur=$umur 
            WHERE PersonID=$id");

        if ($update) {
            header("Location: tabel.php"); // Redirect ke tabel.php setelah simpan
            exit();
        } else {
            echo "Gagal update data.";
        }
    }
} else {
    echo "ID tidak valid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>EDIT DATA</title>
</head>
<body bgcolor="orange">
    <hr>
    <h1 align="center" >EDIT CALON PESERTA KONSER</h1>
    <hr>
    <form method="POST">
        <table align="center">
            <tr>
                <td><label>Nama:</label></td>
                <td><input type="text" name="user" value="<?= ($data['Name']) ?>" required></td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td><input type="email" name="email" value="<?= ($data['email']) ?>" required></td>
            </tr>
            <tr>
                <td><label>Alamat:</label></td>
                <td><input type="alamat" name="alamat" value="<?= ($data['alamat']) ?>" required></td>
            </tr>
            <tr>
                <td><label>Umur : </label></td>
                <td><input type="number" name="umur" value="<?= ($data['umur']) ?>" required></td>
            </tr>
            <tr>
                <td><label>Tanggal Konser : </label></td>
                <td><input type="date" name="tanggal_konser" value="<?= ($data['tanggal_konser']) ?>" required></td>
            </tr>
        </table>
        <div align="center">
            <input type="submit" value="Simpannn">
            <button><a href="koneksi.php">Batal</a></button>
        </div>
    </form>
</body>
</html>
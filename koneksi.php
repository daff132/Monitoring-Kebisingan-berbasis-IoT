<?php
$server = "localhost";
$user = "root";
$password = "";
$db_name = "tgs_7";

$conn = mysqli_connect($server, $user, $password, $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

$sql_create = "CREATE TABLE IF NOT EXISTS daftar_konser (
    PersonID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    email VARCHAR(255),
    alamat VARCHAR(255),
    tanggal_konser DATE,
    umur INT
)";
mysqli_query($conn, $sql_create);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['user']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $alamat = trim($_POST['alamat']);
    $umur = filter_var($_POST['umur'], FILTER_VALIDATE_INT);
    $errors = [];

    if (empty($name)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong";
    }
    if ($umur === false || $umur < 0) {
        $errors[] = "Umur tidak valid";
    }

    if (empty($errors)) {
        $tanggal_konser_input = $_POST['tanggal_konser'];
        
        // Validate date format
        if (empty($tanggal_konser_input)) {
            $errors[] = "Tanggal konser harus diisi";
        } else {
            // Convert date to MySQL format (YYYY-MM-DD)
            $date = DateTime::createFromFormat('Y-m-d', $tanggal_konser_input);
            
            if ($date === false) {
                $errors[] = "Format tanggal tidak valid";
            } else {
                $tanggal_konser = $date->format('Y-m-d');
                
                // Prepare and execute statement
                $stmt = mysqli_prepare($conn, "INSERT INTO daftar_konser (Name, email, alamat, tanggal_konser, umur) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $alamat, $tanggal_konser, $umur);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='success'>Data berhasil disimpan!</div>";
                } else {
                    echo "<div class='error'>Gagal menyimpan data: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt);
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIKET KONSER</title>
</head>
<body bgcolor="orange">
    <hr>
    <h1 align = "center">AYO DAFTAR KONSER SEGERA</h1>
    <hr>
    <form action="" method="POST">
        <table align="center">
            <tr>
                <td>Nama</td>
                <td> : </td>
                <td><input type="text" name="user" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td> : </td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td> : </td>
                <td><input type="text" name="alamat" required></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td> : </td>
                <td><input type="number" name="umur" required></td>
            </tr>
            <tr>
                <td>Tanggal Konser</td>
                <td> : </td>
                <td><input type="date" name="tanggal_konser" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="" value="Gass"></td>
            </tr>
        </table>
    </form>
    <br><br>
    <div align="center">
        <button><a href="tabel.php">Lihat Data</a></button>
    </div>
</body>

</html>
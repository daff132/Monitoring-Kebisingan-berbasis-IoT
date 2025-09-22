<?php
$server = "localhost";
$user = "root";
$password = "";
$db_name = "tgs_7";

// Koneksi ke database
$conn = mysqli_connect($server, $user, $password, $db_name);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM daftar_konser");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Member Baru</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #F3EEE1;
            color: black;
        }

        .button {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid black;
            border-radius: 4px;
            margin-right: 5px;
        }

        .delete {
            color: white;
            background-color: #E32636;
            border: none;
        }

        .edit {
            color: white;
            background-color: #3498db;
            border: none;
        }
    </style>
</head>
<body bgcolor="orange">
    <hr>
    <h1 align="center">CALON PESERTA KONSER</h1>
    <hr>
    <table align="center">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Umur</th>
            <th>Tgl Konser</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['PersonID']) ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['umur']) ?></td>
            <td><?= htmlspecialchars($row['tanggal_konser']) ?></td>
            <td>
                <a class="button edit" href="edit.php?id=<?= $row['PersonID'] ?>">Edit</a>
                <a class="button delete" href="delete.php?id=<?= $row['PersonID'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <div align="center">
        <button for=""><a href="koneksi.php">KEMBALI</a></button>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Verdana', sans-serif; /* Mengganti font untuk tampilan yang lebih modern */
            background-color: #f9f9f9; /* Latar belakang halaman yang lembut */
            color: #333; /* Warna teks dasar */
            margin: 0; /* Menghilangkan margin default */
            padding: 20px; /* Menambahkan padding pada body */
        }

        table {
            border-collapse: collapse;
            width: 90%; /* Mengubah lebar tabel untuk memberikan ruang lebih */
            margin: 20px auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan pada tabel */
            border-radius: 8px; /* Membulatkan sudut tabel */
            overflow: hidden; /* Menghilangkan overflow */
        }

        th,
        td {
            border: 1px solid #ddd; /* Mengubah warna border */
            padding: 15px; /* Menambahkan padding */
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Mengganti warna latar belakang header tabel */
            color: white; /* Warna teks header */
            font-weight: bold; /* Mengatur teks menjadi tebal */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Warna latar belakang baris genap */
        }

        tr:hover {
            background-color: #e0f7fa; /* Mengubah warna saat hover */
        }

        h2 {
            text-align: center;
            color: #4CAF50; /* Mengganti warna judul */
            margin-bottom: 20px; /* Menambahkan margin bawah */
        }

        .delete-btn {
            background-color: #f44336; /* Warna tombol delete */
            color: white;
            padding: 8px 15px; /* Menambah padding */
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Animasi transisi */
        }

        .delete-btn:hover {
            background-color: #e53935; /* Warna tombol saat hover */
        }

        .add-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #2196F3; /* Warna tombol tambah */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease; /* Animasi transisi */
        }

        .add-btn:hover {
            background-color: #1976D2; /* Warna tombol tambah saat hover */
        }
    </style>
</head>


<body>

    <h2>Data Penduduk Kecamatan</h2>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Ganti dengan password MySQL Anda
    $dbname = "penduduk_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Menghapus data
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $delete_sql = "DELETE FROM penduduk WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<p style='text-align:center;color:green;'>Data berhasil dihapus</p>";
        } else {
            echo "<p style='text-align:center;color:red;'>Gagal menghapus data</p>";
        }
        $stmt->close();
    }

    // Menampilkan data
    $sql = "SELECT * FROM penduduk";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr>
        <th>Kecamatan</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Luas</th>
        <th>Jumlah Penduduk</th>
        <th>Aksi</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["kecamatan"]) . "</td><td>" .
                htmlspecialchars($row["longitude"]) . "</td><td>" .
                htmlspecialchars($row["latitude"]) . "</td><td>" .
                htmlspecialchars($row["luas"]) . "</td><td>" .
                htmlspecialchars($row["jumlah_penduduk"]) . "</td>
                <td><a class='delete-btn' href='index.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>0 results</p>";
    }

    $conn->close();
    ?>

    <br>
    <div style="text-align:center;">
        <a href="input.php">Tambah Data</a>
    </div>

</body>

</html>

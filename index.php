<head>
    <style>
       body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #a1d4e5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            color: #0d1419; 
            margin-bottom: 20px; 
            font-size: 18px; 
        }

        .delete-btn {
            background-color: #f44336; 
            color: white;
            padding: 5px 10px; 
            font-size: 12px; 
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }

        .delete-btn:hover {
            background-color: #e53935; 
        } /* Menambahkan kurung tutup di sini */

        .add-btn {
            display: inline-block;
            margin: 15px auto;
            padding: 8px 15px;
            background-color: #2196F3; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            transition: background-color 0.3s ease; /* Animasi transisi */
        }

        .add-btn:hover {
            background-color: #1976D2; 
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
                <td><a class='delete-btn' href='index.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a></td>
                <td><a class='add-btn' href='input.php?id=" . $row["id"] . "'>Update</a></td></tr>";  // Menambahkan link Update
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>0 results</p>";
    }

    $conn->close();
    ?>


</body>

</html>

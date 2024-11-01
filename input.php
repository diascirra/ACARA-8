<!DOCTYPE html>
<html>

<body>

    <?php
    // Variabel untuk menyimpan nilai default
    $kecamatan = $luas = $latitude = $longitude = $jumlah_penduduk = "";
    $id = 0; // Inisialisasi ID

    // Cek apakah ada id yang dikirim untuk update
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kecamatan = $_POST['kecamatan'];
        $luas = $_POST['luas'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $jumlah_penduduk = $_POST['jumlah_penduduk'];

        // Sesuaikan dengan setting MySQL 
        $servername = "localhost";
        $username = "root";
        $password = ""; // Ganti dengan password MySQL Anda
        $dbname = "penduduk_db";

        // Create connection 
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($id > 0) {
            // Jika ID ada, maka update data
            $sql = "UPDATE penduduk SET 
                    kecamatan='$kecamatan', 
                    luas=$luas, 
                    latitude=$latitude, 
                    longitude=$longitude, 
                    jumlah_penduduk=$jumlah_penduduk 
                    WHERE id=$id";
        } else {
            // Jika ID tidak ada, maka insert data baru
            $sql = "INSERT INTO penduduk (kecamatan, luas, latitude, longitude, jumlah_penduduk) 
                    VALUES ('$kecamatan', $luas, $latitude, $longitude, $jumlah_penduduk)";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Record berhasil disimpan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        // Cek apakah kita harus mengambil data untuk update
        if ($id > 0) {
            // Ambil data dari database untuk ditampilkan di formulir
            $servername = "localhost";
            $username = "root";
            $password = ""; // Ganti dengan password MySQL Anda
            $dbname = "penduduk_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM penduduk WHERE id=$id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Mengisi nilai-nilai ke dalam form
                $kecamatan = $row['kecamatan'];
                $luas = $row['luas'];
                $latitude = $row['latitude'];
                $longitude = $row['longitude'];
                $jumlah_penduduk = $row['jumlah_penduduk'];
            }

            $conn->close();
        }
    }
    ?>

    <h2>Form Input Data Penduduk</h2>
    <form action="input.php?id=<?php echo $id; ?>" method="post">
        <label for="kecamatan">Kecamatan:</label><br>
        <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($kecamatan); ?>"><br>

        <label for="luas">Luas (ha):</label><br>
        <input type="number" id="luas" name="luas" value="<?php echo htmlspecialchars($luas); ?>"><br>

        <label for="jumlah_penduduk">Jumlah Penduduk:</label><br>
        <input type="number" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo htmlspecialchars($jumlah_penduduk); ?>"><br>

        <label for="latitude">Latitude:</label><br>
        <input type="number" step="any" id="latitude" name="latitude" value="<?php echo htmlspecialchars($latitude); ?>"><br>

        <label for="longitude">Longitude:</label><br>
        <input type="number" step="any" id="longitude" name="longitude" value="<?php echo htmlspecialchars($longitude); ?>"><br><br>

        <input type="submit" value="Submit">
    </form>

</body>

</html>

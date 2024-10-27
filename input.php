<!DOCTYPE html>
<html>

<body>

    <?php
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

        $sql = "INSERT INTO penduduk (kecamatan, luas, latitude, longitude, jumlah_penduduk) 
                VALUES ('$kecamatan', $luas, $latitude, $longitude, $jumlah_penduduk)";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Formulir belum dikirim.";
    }
    ?>
</body>

</html>
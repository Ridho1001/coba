<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Karyawan</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
  }
  .container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  h1 {
    text-align: center;
    color: #333;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #f2f2f2;
  }
  tr:hover {
    background-color: #f9f9f9;
  }
</style>
</head>
<body>

<div class="container">
  <h1>Data Karyawan</h1>
  <table>
    <thead>
      <tr>
        <th>ID Karyawan</th>
        <th>Nama</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>No. Telepon</th>
        <th>Jabatan</th>
        <th>Foto</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "karyawansi";

      $conn = new mysqli($servername, $username, $password, $database);

      if ($conn->connect_error) {
          die("Koneksi ke database gagal: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM tb_karyawan";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["id_karyawan"] . "</td>";
              echo "<td>" . $row["nama"] . "</td>";
              echo "<td>" . $row["tmp_tgl_lahir"] . "</td>";
              echo "<td>" . $row["jenkel"] . "</td>";
              echo "<td>" . $row["alamat"] . "</td>";
              echo "<td>" . $row["no_tel"] . "</td>";
              echo "<td>" . $row["jabatan"] . "</td>";
              echo "<td><img src='" . $row["foto"] . "' alt='Foto Karyawan' style='max-width: 100px;'></td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='8'>Tidak ada data karyawan.</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>
</div>

</body>
</html>

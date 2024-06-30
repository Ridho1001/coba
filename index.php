<?php
session_start();

// Set informasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "smartloker";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Inisialisasi variabel
$success = "";
$error_login = "";
$error = "";

// Proses registrasi
if (isset($_POST['register'])) {
    $username_reg = $_POST['username_reg'];
    $password_reg = password_hash($_POST['password_reg'], PASSWORD_BCRYPT);

    $sql_register = "INSERT INTO login (username, password) VALUES ('$username_reg', '$password_reg')";
    if ($conn->query($sql_register) === TRUE) {
        $success = "Registrasi berhasil. Silakan login.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Proses login
if (isset($_POST['login'])) {
    $username_login = $_POST['username_login'];
    $password_login = $_POST['password_login'];

    $sql_login = "SELECT * FROM login WHERE username='$username_login'";
    $result = $conn->query($sql_login);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password_login, $row['password'])) {
            $_SESSION['user'] = $username_login; // Set session user
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        } else {
            $error_login = "Username atau password salah.";
        }
    } else {
        $error_login = "Username atau password salah.";
    }
}

// Proses logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Proses tambah pengguna baru
if (isset($_POST['add_pengguna'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];

    $sql_add_pengguna = "INSERT INTO Pengguna (Nama, NIM) VALUES ('$nama', '$nim')";
    if ($conn->query($sql_add_pengguna) === TRUE) {
        $success = "Pengguna berhasil ditambahkan.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Proses update pengguna
if (isset($_POST['update_pengguna'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];

    $sql_update_pengguna = "UPDATE Pengguna SET Nama='$nama', NIM='$nim' WHERE IDPengguna='$id'";
    if ($conn->query($sql_update_pengguna) === TRUE) {
        $success = "Data pengguna berhasil diperbarui.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Proses delete pengguna
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_delete_pengguna = "DELETE FROM Pengguna WHERE IDPengguna='$id'";
    if ($conn->query($sql_delete_pengguna) === TRUE) {
        $success = "Data pengguna berhasil dihapus.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Validasi sesi login
if (!isset($_SESSION['user'])) {
    // Jika belum login, tampilkan form login
    echo <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Loker Inventory - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 300px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="{$_SERVER['PHP_SELF']}">
            <label for="username_login">Username:</label>
            <input type="text" id="username_login" name="username_login" required>
            <label for="password_login">Password:</label>
            <input type="password" id="password_login" name="password_login" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Belum punya akun? <a href="#" onclick="toggleRegister()">Registrasi disini</a></p>
        <div id="register" style="display:none;">
            <h2>Registrasi</h2>
            <form method="post" action="{$_SERVER['PHP_SELF']}">
                <label for="username_reg">Username:</label>
                <input type="text" id="username_reg" name="username_reg" required>
                <label for="password_reg">Password:</label>
                <input type="password" id="password_reg" name="password_reg" required>
                <button type="submit" name="register">Register</button>
            </form>
            <p style="color: green;">$success</p>
            <p style="color: red;">$error</p>
        </div>
        <p style="color: red;">$error_login</p>
    </div>
</div>

<script>
    function toggleRegister() {
        var registerForm = document.getElementById('register');
        if (registerForm.style.display === 'none') {
            registerForm.style.display = 'block';
        } else {
            registerForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
HTML;
    exit;
}

// Setelah login berhasil, tampilkan halaman dashboard
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Loker Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: row;
        }
        .sidebar {
            width: 20%;
            background-color: #f1f1f1;
            padding: 20px;
        }
        .content {
            width: 80%;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .menu-item {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .menu-item:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
    <script>
        function showDashboard() {
            document.getElementById("dashboard").style.display = "block";
            document.getElementById("pengguna").style.display = "none";
            document.getElementById("transaksi").style.display = "none";
            document.getElementById("loker").style.display = "none";
        }

        function showData(section) {
            document.getElementById("dashboard").style.display = "none";
            document.getElementById("pengguna").style.display = "none";
            document.getElementById("transaksi").style.display = "none";
            document.getElementById("loker").style.display = "none";

            document.getElementById(section).style.display = "block";
        }
    </script>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <a href="#" class="menu-item" onclick="showDashboard()">Dashboard</a>
        <a href="#" class="menu-item" onclick="showData('pengguna')">Data Pengguna</a>
        <a href="#" class="menu-item" onclick="showData('transaksi')">Data Transaksi</a>
        <a href="#" class="menu-item" onclick="showData('loker')">Data Loker</a>
        <a href="?logout=true" class="menu-item">Logout</a>
    </div>

    <div class="content">
        <h1 id="dashboard">Dashboard</h1>
        <div class="dashboard">
            <img src="lokergambar.jpg" alt="Loker Image">
            <p>Selamat datang di Smart Loker Inventory, <?php echo $_SESSION['user']; ?>!</p>
        </div>

        <!-- Data Pengguna -->
        <div id="pengguna" style="display: none;">
            <h2>Data Pengguna</h2>
            <table>
                <tr>
                    <th>ID Pengguna</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $sql_pengguna = "SELECT * FROM Pengguna";
                $result_pengguna = $conn->query($sql_pengguna);

                if ($result_pengguna->num_rows > 0) {
                    while ($row = $result_pengguna->fetch_assoc()) {
                        echo "<tr>";
                        echo "<form method='post' action='{$_SERVER['PHP_SELF']}'>";
                        echo "<td>" . $row["IDPengguna"] . "</td>";
                        echo "<td><input type='text' name='nama' value='" . $row["Nama"] . "'></td>";
                        echo "<td><input type='text' name='nim' value='" . $row["NIM"] . "'></td>";
                        echo "<td>";
                        echo "<input type='hidden' name='id' value='" . $row["IDPengguna"] . "'>";
                        echo "<input type='submit' name='update_pengguna' value='Edit' class='button'>";
                        echo "<a class='button' href='{$_SERVER['PHP_SELF']}?action=delete&id=" . $row["IDPengguna"] . "'>Hapus</a>";
                        echo "</td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data pengguna.</td></tr>";
                }
                ?>
            </table>
            <h2>Tambah Pengguna Baru</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" required>
                <input type="submit" name="add_pengguna" value="Tambah" class="button">
            </form>
            <p style="color: green;"><?php echo $success; ?></p>
            <p style="color: red;"><?php echo $error; ?></p>
        </div>

        <!-- Data Transaksi -->
        <div id="transaksi" style="display: none;">
            <h2>Data Transaksi</h2>
            <table>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID Pengguna</th>
                    <th>ID Loker</th>
                    <th>Waktu Pinjam</th>
                    <th>Waktu Kembali</th>
                    <th>Barang Pinjam</th>
                </tr>
                <?php
                $sql_transaksi = "SELECT * FROM Transaksi";
                $result_transaksi = $conn->query($sql_transaksi);

                if ($result_transaksi->num_rows > 0) {
                    while ($row = $result_transaksi->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDTransaksi"] . "</td>";
                        echo "<td>" . $row["IDPengguna"] . "</td>";
                        echo "<td>" . $row["IDLoker"] . "</td>";
                        echo "<td>" . $row["WaktuPinjam"] . "</td>";
                        echo "<td>" . $row["WaktuKembali"] . "</td>";
                        echo "<td>" . $row["BarangPinjam"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data transaksi.</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Data Loker -->
        <div id="loker" style="display: none;">
            <h2>Data Loker</h2>
            <table>
                <tr>
                    <th>ID Loker Utama</th>
                    <th>Nomor Loker</th>
                </tr>
                <?php
                $sql_loker = "SELECT * FROM Loker";
                $result_loker = $conn->query($sql_loker);

                if ($result_loker->num_rows > 0) {
                    while ($row = $result_loker->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IDLokerUtama"] . "</td>";
                        echo "<td>" . $row["NomorLoker"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data loker.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>

<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "/srv/http/kuliah/uas/src/utils/conn.php";
include '/srv/http/kuliah/uas/src/utils/guard.php';

$id_user = $_SESSION["id_user"];
$id_hak = $_SESSION["id_hak"];
switch ($id_hak) {
  case '3':
    $sql = "
        SELECT m.*, ha.nama_hak, k.nama_kelas, k.angkatan, j.nama_jurusan, d.nama_departemen
        FROM mahasiswa m
        JOIN users u ON m.id_user = u.id_user
        JOIN hak_akses ha ON u.id_hak = ha.id_hak
        JOIN kelas k ON m.id_kelas = k.id_kelas
        JOIN jurusan j ON k.id_jurusan = j.id_jurusan
        JOIN departemen d ON j.id_departemen = d.id_departemen
        WHERE m.id_user = $id_user
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $nama = $row["nama"];
      $nrp = $row["nrp"];
      $id_kelas = $row["id_kelas"];
      $hak = $row["nama_hak"];
      $_SESSION["user_data"] = $row;
      $_SESSION["registered"] = true;
    }
    else{
      $_SESSION["registered"] = false;
    }
    break;
  case '2':
    $sql = "SELECT d.*, ha.nama_hak, de.nama_departemen 
    FROM dosen d 
    JOIN users u ON d.id_user = u.id_user 
    JOIN hak_akses ha ON u.id_hak = ha.id_hak 
    JOIN departemen de ON d.id_departemen = de.id_departemen 
    WHERE d.id_user = $id_user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $nama = $row["nama"];
      $nrp = $row["nip"];
      $hak = $row["nama_hak"];
      $_SESSION["user_data"] = $row;
      $_SESSION["registered"] = true;
    }
    else{
      $_SESSION["registered"] = false;
    }
    break;
  default:
    # code...
    break;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo $title; ?></title>
    <link href="/kuliah/uas/src/style.css" rel="stylesheet" />
<link rel="icon" type="image/x-icon" href="../../assets/icon.png">
  </head>
  <body class="bg-pasca">
    <?php 
    include 'nav.php';
    ?>
    <div class="flex pt-24 overflow-hidden bg-gray-50 dark:bg-gray-900">
      <?php 
      include 'aside.php';
      ?>
      <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
          <main>
            <?php echo $content; ?>
          </main>
          <?php 
          include 'footer.html';
          ?>
      </div>
    </div>
    <script src="/kuliah/uas/node_modules/flowbite/dist/flowbite.min.js"></script>
  </body>
</html>

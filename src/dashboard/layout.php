<?php 
include "../utils/conn.php";
include '../utils/guard.php';
$id_user = $_SESSION["id_user"];
$id_hak = $_SESSION["id_hak"];
$sql = "SELECT * FROM mahasiswa WHERE id_user = $id_user";
$sql2 = "SELECT * FROM hak_akses WHERE id_hak = $id_hak";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $nama = $row["nama"];
  $nrp = $row["nrp"];
  $id_kelas = $row["id_kelas"];
  $hak = $result2->fetch_assoc()["nama_hak"];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo $title; ?></title>
    <link href="../style.css" rel="stylesheet" />
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
            <?php 
echo $content;
?>
          </main>
          <?php 
          include 'footer.html';
          ?>
      </div>
    </div>
    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
  </body>
</html>

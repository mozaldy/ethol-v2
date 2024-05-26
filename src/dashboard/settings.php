<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include "../utils/conn.php";
session_start();
$title = "Dashboard | Settings";

if($_SESSION["registered"]){
  $user_data = $_SESSION["user_data"];
}

ob_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $nrp = $_POST['nrp'];
    $id_kelas = $_POST['kelas'];
    $id_user = $_SESSION['id_user'];
    $sql = "INSERT INTO mahasiswa (nama, nrp, id_kelas, id_user) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssid", $name, $nrp, $id_kelas, $id_user);
    if($stmt->execute())
  {
    header("Location: index.php");
    exit();
  }
  else{
    echo "Error: ". $conn->error;
  }
    $stmt->close();
}

$departments = [];
$sql = "SELECT id_departemen, nama_departemen FROM departemen";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}
?>
<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
      <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Lengkapi Biodata Anda</h2>
      <form action="" method="post">
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="sm:col-span-2">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
<input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Input nama" value="<?php echo $user_data["nama"]; ?>" required="">
              </div>
              <div class="sm:col-span-2">
                  <label for="nrp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRP</label>
                  <input type="text" name="nrp" id="nrp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Input NRP" value="<?php echo $user_data["nrp"]?>" required="">
              </div>
              <div class="w-full">
                  <label for="departemen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departemen</label>
<?php echo $_SESSION["registered"] ? '
<select disabled id="departemen" name="departemen" class="bg-gray-200 border border-gray-300 text-gray-900 cursor-not-allowed text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">
'.$user_data["nama_departemen"] : '
<select id="departemen" name="departemen" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">Select departemen
' ?>
</option>
                      <?php foreach ($departments as $department): ?>
                        <option value="<?= $department['id_departemen'] ?>"><?= htmlspecialchars($department['nama_departemen']) ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div>
                  <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
<?php echo $_SESSION["registered"] ? '
<select disabled id="jurusan" name="jurusan" class="bg-gray-200 border border-gray-300 text-gray-900 cursor-not-allowed text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">
'.$user_data["nama_jurusan"] : '
<select id="jurusan" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">Select jurusan
' ?>
</option>
                  </select>
              </div>
              <div>
                  <label for="angkatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Angkatan</label>
<?php echo $_SESSION["registered"] ? '
<select disabled id="angkatan" name="angkatan" class="bg-gray-200 border border-gray-300 text-gray-900 cursor-not-allowed text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">
'.$user_data["angkatan"] : '
<select id="angkatan" name="angkatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">Select angkatan
' ?>
</option>
                      <option value="2023">2023</option>
                      <option value="2022">2022</option>
                      <option value="2021">2021</option>
                      <option value="2020">2020</option>
                  </select>
              </div>
              <div>
                  <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
<?php echo $_SESSION["registered"] ? '
<select disabled id="kelas" name="kelas" class="bg-gray-200 border border-gray-300 text-gray-900 cursor-not-allowed text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option selected="">
'.$user_data["nama_kelas"] : '
<select id="kelas" name="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
<option selected="">Select kelas
' ?>
                      </option>
                  </select>
              </div>
          </div>
          <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
              Submit Biodata
          </button>
      </form>
  </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("departemen").addEventListener("change", function () {
        var id_departemen = this.value;
        var jurusanSelect = document.getElementById("jurusan");
        var kelasSelect = document.getElementById("kelas");

        // Reset jurusan and kelas selects
        jurusanSelect.innerHTML = '<option value="" selected>Select jurusan</option>';
        kelasSelect.innerHTML = '<option value="" selected>Select kelas</option>';
console.log(id_departemen);

        if (id_departemen) {
            fetch("../utils/get_jurusan.php?id_departemen=" + id_departemen)
                .then(response => response.json())
                .then(data => {
                    data.forEach(jurusan => {
                        var option = document.createElement("option");
                        option.value = jurusan.id_jurusan;
                        option.textContent = jurusan.nama_jurusan;
                        jurusanSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching jurusan:", error));
        }
    });

    document.getElementById("jurusan").addEventListener("change", function () {
        var id_jurusan = this.value;
        var angkatan = document.getElementById("angkatan").value;
        var kelasSelect = document.getElementById("kelas");

        // Reset kelas select
        kelasSelect.innerHTML = '<option value="" selected>Select kelas</option>';

        if (id_jurusan && angkatan) {
                console.log(id_jurusan, angkatan);
                    fetch(`../utils/get_kelas.php?id_jurusan=${id_jurusan}&angkatan=${angkatan}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(kelas => {
                                var option = document.createElement("option");
                                option.value = kelas.id_kelas;
                                option.textContent = kelas.nama_kelas;
                                kelasSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error fetching kelas:", error));
                }
    });
});

document.getElementById("angkatan").addEventListener("change", function () {
    var id_jurusan = document.getElementById("jurusan").value;
    var angkatan = this.value;
    var kelasSelect = document.getElementById("kelas");

    // Reset kelas select
    kelasSelect.innerHTML = '<option value="" selected>Select kelas</option>';

    // Check if id_jurusan and angkatan are valid
    if (id_jurusan && angkatan) {
        fetch(`../utils/get_kelas.php?id_jurusan=${id_jurusan}&angkatan=${angkatan}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(kelas => {
                    var option = document.createElement("option");
                    option.value = kelas.id_kelas;
                    option.textContent = kelas.nama_kelas;
                    kelasSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching kelas:", error));
    }
});
</script>
<?php $content = ob_get_clean(); include 'layout.php'; ?>

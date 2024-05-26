<?php
include "/srv/http/kuliah/uas/src/utils/conn.php";
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$title = "Dashboard | Detail";

// Retrieve the id from the URL
$id_matkul_kelas = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
$is_tugas = isset($_POST['is_tugas']) ? 1 : 0;
    $tenggat = isset($_POST['tenggat']) ? $_POST['tenggat'] : null;
  $tenggat_timestamp = strtotime($tenggat);
$tenggat_date = $tenggat ? date('Y-m-d', $tenggat_timestamp) : NULL;
  $upload_dir = "/srv/http/kuliah/uas/assets/uploads/$id_matkul_kelas/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!is_writable($upload_dir)) {
    echo "Error: Upload directory is not writable.";
    exit;
}
    move_uploaded_file($file_temp, $upload_dir . $file_name);

  $stmt = $conn->prepare("INSERT INTO materi (nama_materi, deskripsi_materi, path_materi, ukuran_materi, tipe_materi, id_matkul_kelas, uploaded_at, tenggat, is_tugas) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)");

  $upload_dir = "/kuliah/uas/assets/uploads/$id_matkul_kelas/";
  $path = $upload_dir.$file_name;
  $stmt->bind_param("sssisisi", $judul, $deskripsi, $path, $file_size, $file_type, $id_matkul_kelas, $tenggat_date, $is_tugas);
    $stmt->execute();
    $stmt->close();
}

$sql = "
    SELECT 
        mk.nama_matkul, 
        mkc.hari, 
        mkc.jam, 
        mkc.ruang, 
        d.nama AS nama_dosen
    FROM 
        mata_kuliah mk
    JOIN 
        matkul_kelas mkc ON mk.id_matkul = mkc.id_matkul
    JOIN 
        matkul_dosen md ON mk.id_matkul = md.id_matkul
    JOIN 
        dosen d ON md.nip = d.nip
    WHERE 
        mkc.id_matkul_kelas = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_matkul_kelas);
$stmt->execute();
$result = $stmt->get_result();
$detail = $result->fetch_assoc();

$stmt_materi = $conn->prepare("SELECT * FROM materi WHERE id_matkul_kelas = ? AND is_tugas = 0");
$stmt_materi->bind_param("i", $id_matkul_kelas);
$stmt_materi->execute();
$result_materi = $stmt_materi->get_result();

$stmt_tugas = $conn->prepare("SELECT * FROM materi WHERE id_matkul_kelas = ? AND is_tugas = 1");
$stmt_tugas->bind_param("i", $id_matkul_kelas);
$stmt_tugas->execute();
$result_tugas = $stmt_tugas->get_result();

$stmt->close();
$conn->close();

// Check if any detail is found
if (!$detail) {
    echo "No details found for the selected item.";
    exit;
}

// Start output buffering to capture the content
ob_start();
?>
<div class="px-4 pt-6">
  <div class="grid gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Mata Kuliah</h1>
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Mata Kuliah: <?php echo htmlspecialchars($detail['nama_matkul']); ?></h2>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400"><strong>Jadwal:</strong> <?php echo htmlspecialchars($detail['hari']) . ', ' . htmlspecialchars($detail['jam']); ?></p>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400"><strong>Ruangan:</strong> <?php echo htmlspecialchars($detail['ruang']); ?></p>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400"><strong>Dosen:</strong> <?php echo htmlspecialchars($detail['nama_dosen']); ?></p>
      </div>
    </div>

<?php 
include 'tabel_materi.php';
include 'tabel_tugas.php';
?>
<div class="<?php echo $_SESSION["id_hak"] == '3' ? 'hidden' : '' ?> bg-white grid gap-5 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Upload Materi atau Tugas</h1>
<form action="" method="post" enctype="multipart/form-data">
<div class="grid grid-cols-1 items-center justify-center w-full">
<div class="mb-5">
    <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul: </label>
    <input name="judul" type="text" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Materi MTK 1" required />
  </div>
<div class="mb-5">
    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi: </label>
    <input name="deskripsi" type="text" id="deskripsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Lorem Ipsum Dolor Sit Amet" required />
  </div>
<label class="inline-flex items-center mb-5 cursor-pointer">
  <input type="checkbox" id="tugasCheckbox" name="is_tugas" value="" class="sr-only peer">
  <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tugas</span>
</label>



<div class="mb-5">
<div class="relative max-w-sm hidden" id="datepickerContainer">
<div class="flex">
  <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
    </svg>
  </div>
  <input  datepicker  name="tenggat" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tenggat">

  </div>
</div>

<div class="my-5">
  <label for="tipe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lampiran: </label>


  </div>
    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 mb-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
        </div>
        <input id="dropzone-file" name="file" type="file" />
    </label>
</div> 
<button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 mt-2 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Upload</button>
</form>
    </div>
    </div>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
<script>
    document.getElementById('tugasCheckbox').addEventListener('change', function() {
        var datepickerContainer = document.getElementById('datepickerContainer');
        if (this.checked) {
            datepickerContainer.style.display = 'block';
        } else {
            datepickerContainer.style.display = 'none';
        }
    });
</script>
<?php
// Capture the content and include the layout
$content = ob_get_clean();
include '../layout.php';
?>

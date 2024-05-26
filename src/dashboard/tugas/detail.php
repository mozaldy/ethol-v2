<?php
ob_start();
include "/srv/http/kuliah/uas/src/utils/conn.php";
session_start();

$id_materi = $_GET["id"];
$id_user = $_SESSION["id_user"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $path_tugas = "/srv/http/kuliah/uas/assets/uploads/pengumpulan/$id_user/" . basename($_FILES["file"]["name"]);
    echo $path_tugas;
        // Create directory if it doesn't exist
        if (!file_exists("/srv/http/kuliah/uas/assets/uploads/pengumpulan/$id_user")) {
            mkdir("/srv/http/kuliah/uas/assets/uploads/pengumpulan/$id_user", 0777, true);
        }

        // Upload file to the specified directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $path_tugas)) {
            // File uploaded successfully, now insert into database
            $sql_insert = "INSERT INTO pengumpulan_penugasan (id_user, path_tugas, id_materi, tanggal_pengumpulan) VALUES (?, ?, ?, NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("isi", $id_user, $path_tugas, $id_materi);
            $stmt_insert->execute();
            $stmt_insert->close();

            echo "File uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No file uploaded.";
    }
}

$sql = "SELECT m.nama_materi, m.deskripsi_materi, m.path_materi, m.tenggat, mk.nama_matkul
        FROM materi m
        JOIN matkul_kelas mkc ON m.id_matkul_kelas = mkc.id_matkul_kelas
        JOIN mata_kuliah mk ON mkc.id_matkul = mk.id_matkul
        WHERE m.id_materi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_materi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Assignment not found";
} else {
    $assignment = $result->fetch_assoc();
?>

<!-- Display assignment details -->
<div class="px-4 pt-6">
  <div class="grid gap-4">
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Tugas: <?php echo htmlspecialchars($assignment['nama_materi']); ?></h3>
    <p class="mb-4 text-sm text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($assignment['deskripsi_materi']); ?></p>
    <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">Mata Kuliah: <?php echo htmlspecialchars($assignment['nama_matkul']); ?></p>
    <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">Tenggat: <?php echo htmlspecialchars($assignment['tenggat']); ?></p>
    <a href="<?php echo htmlspecialchars($assignment['path_materi']); ?>" class="text-sm text-blue-500 dark:text-blue-400 hover:underline">Download Materi</a>
  </div>
<div class="<?php echo $_SESSION["id_hak"] == '2' ? 'hidden' : '' ?> bg-white grid gap-5 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pengumpulan Tugas</h1>
<form action="" method="post" enctype="multipart/form-data">
<div class="grid grid-cols-1 items-center justify-center w-full">
<div class="mb-5">
<div class="relative max-w-sm hidden" id="datepickerContainer">
<div class="flex">
  <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
    </svg>
  </div>

  </div>
</div>

<div class="my-5">
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
<?php
}
$stmt->close();
$conn->close();
// Capture the content and include the layout
$content = ob_get_clean();
include '../layout.php';
?>

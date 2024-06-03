<?php
ob_start();

include "/srv/http/kuliah/uas/src/utils/conn.php";
session_start();

$id_penugasan = $_GET["id"];

$sql_submission = "SELECT p.*, mh.nrp, mh.nama 
FROM pengumpulan_penugasan p
JOIN mahasiswa mh ON p.id_user = mh.id_user
JOIN materi m ON p.id_materi = m.id_materi
JOIN matkul_kelas mkc ON m.id_matkul_kelas = mkc.id_matkul_kelas
JOIN matkul_dosen mkd ON mkc.id_matkul = mkd.id_matkul
JOIN dosen d ON mkd.nip = d.nip
WHERE p.id_penugasan = ? AND d.nip = ?;";
$stmt_submission = $conn->prepare($sql_submission);
$stmt_submission->bind_param("ii", $id_penugasan, $_SESSION["user_data"]["nip"]);
$stmt_submission->execute();
$result_submission = $stmt_submission->get_result();

if ($result_submission->num_rows === 0) {
    header("Location: ../tugas/");
} else {
    $submission = $result_submission->fetch_assoc();
    ?>

<!-- Display submission details -->
<div class="px-4 pt-6">
    <div class="grid gap-4">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Detail Pengumpulan Tugas</h3>
            <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">Nama: <?php echo htmlspecialchars($submission['nama']); ?></p>
            <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">NRP: <?php echo htmlspecialchars($submission['nrp']); ?></p>
            <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">Tanggal Pengumpulan: <?php echo htmlspecialchars($submission['tanggal_pengumpulan']); ?></p>

<span 
class="cursor-pointer bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-blue-400 border border-blue-100 dark:border-blue-500">
                      <a download href="<?php echo htmlspecialchars($submission["path_tugas"]); ?>">Download Tugas</a>
</span>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form action="" method="post">
                <label for="nilai" class="block mb-2">Nilai:</label>
                <input type="number" id="nilai" name="nilai" class="border border-gray-300 px-4 py-2 rounded-lg mb-4" required>

                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 mt-2 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Update</button>
            </form>
    </div>
    </div>
</div>

<?php
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nilai = $_POST["nilai"];

    $sql_update = "UPDATE pengumpulan_penugasan SET nilai_tugas = ? WHERE id_penugasan = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $nilai, $id_penugasan);
    $stmt_update->execute();

    header('Location: ../tugas/');
}
?>

<?php
$content = ob_get_clean();
include '../layout.php';
?>

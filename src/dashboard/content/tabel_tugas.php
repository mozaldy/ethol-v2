<?php 
include "/srv/http/kuliah/uas/src/utils/conn.php";
session_start();

$id_kelas = $_SESSION["user_data"]["id_kelas"];
$id_hak = $_SESSION["id_hak"];
$id_user = $_SESSION["id_user"];

// SQL query to fetch the required data
switch ($id_hak) {
  case '3':
    $sql = "
SELECT mk.nama_matkul,
       m.nama_materi,
       m.id_materi,
       m.tenggat, COALESCE(pp.nilai_tugas, '-') AS 'nilai'
FROM materi m
JOIN matkul_kelas mkc ON m.id_matkul_kelas = mkc.id_matkul_kelas
JOIN mata_kuliah mk ON mkc.id_matkul = mk.id_matkul
LEFT JOIN pengumpulan_penugasan pp ON m.id_materi = pp.id_materi
WHERE m.is_tugas = 1
AND mkc.id_kelas = ?;
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kelas);
    break;
  case '2':
    $sql = "
        SELECT 
            mk.nama_matkul, 
            mkc.hari, 
            mkc.id_matkul_kelas, 
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
            d.id_user = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
  break;
}

$stmt->execute();
$result = $stmt->get_result();

$tugas_tugas = [];

while ($row = $result->fetch_assoc()) {
    $tugas_tugas[] = $row;
}

$stmt->close();
$conn->close();
?>

<!-- Main widget -->
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <!-- Card header -->
  <div class="items-center justify-between lg:flex">
    <div class="mb-4 lg:mb-0">
      <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Mata Kuliah</h3>
      <span class="text-base font-normal text-gray-500 dark:text-gray-400">Kuliah Semester Genap Tahun Ajaran 2023</span>
    </div>
  </div>
  <!-- Table -->
  <div class="flex flex-col mt-6">
    <div class="overflow-x-auto rounded-lg">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Mata Kuliah</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Judul</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Tenggat</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Nilai</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Status</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
              <?php foreach ($tugas_tugas as $tugas): ?>
              <tr>
                <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($tugas['nama_matkul']); ?>
                </td>
                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                  <?php echo htmlspecialchars($tugas['nama_materi']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($tugas['tenggat']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($tugas['nilai']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <div class="flex-shrink-0">
<?php 
if ($tugas['nilai'] == "-" && $tugas['tenggat'] < date('Y-m-d H:i:s')) {
                      echo'<span
class="cursor-pointer bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 border border-red-100 dark:border-red-500">
Terlambat Mengumpulkan
</span>';
}
elseif ($tugas['nilai'] != "-") {
                      echo'<span
class="cursor-pointer bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">
Sudah Mengumpulkan
</span>';
}
else {
                      echo'<span
class="cursor-pointer bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-500">
Belum Mengumpulkan
</span>';
}
?>
                  </div>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <div class="flex-shrink-0">
<a href="/kuliah/uas/src/dashboard/tugas/detail.php?id=<?php echo htmlspecialchars($tugas['id_materi']); ?>
" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
                      Detail Tugas
                      <svg class="w-4 h-4 ml-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Card Footer -->
  <div class="flex items-center justify-between pt-3 sm:pt-6">
    <div class="flex-shrink-0">
      <a href="#" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
        Detail Mata Kuliah
        <svg class="w-4 h-4 ml-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
    </div>
  </div>
</div>

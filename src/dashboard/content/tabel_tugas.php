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
SELECT 
    m.id_materi, 
    m.nama_materi, 
    m.deskripsi_materi, 
    m.ukuran_materi, 
    m.tipe_materi, 
    m.path_materi, 
    m.uploaded_at, 
    m.tenggat, 
    m.is_tugas, 
    mk.nama_matkul,
    p.path_tugas AS tugas_path, 
    COALESCE(p.nilai_tugas, '-') AS nilai, 
    p.tanggal_pengumpulan
FROM 
    materi m
LEFT JOIN 
    pengumpulan_penugasan p ON m.id_materi = p.id_materi AND p.id_user = ?
JOIN 
    matkul_kelas mkc ON m.id_matkul_kelas = mkc.id_matkul_kelas
JOIN 
    mata_kuliah mk ON mkc.id_matkul = mk.id_matkul
JOIN 
    mahasiswa mh ON mkc.id_kelas = mh.id_kelas
WHERE 
    mh.id_user = ? AND m.is_tugas = 1
ORDER BY 
    m.tenggat DESC;
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $id_user);
  break;
  case '2':
    $id_dosen = $_SESSION["user_data"]["nip"];
    $sql = "
SELECT 
    m.*, 
    mk.nama_matkul,
    (SELECT COUNT(*) 
     FROM mahasiswa mh
     JOIN matkul_kelas mkc2 ON mh.id_kelas = mkc2.id_kelas
     WHERE mkc2.id_matkul_kelas = mkc.id_matkul_kelas) AS jumlah_mahasiswa,
    (SELECT COUNT(*)
     FROM pengumpulan_penugasan p
     WHERE p.id_materi = m.id_materi) AS jumlah_mahasiswa_mengumpulkan
FROM 
    materi m
JOIN 
    matkul_kelas mkc ON m.id_matkul_kelas = mkc.id_matkul_kelas
JOIN 
    mata_kuliah mk ON mkc.id_matkul = mk.id_matkul
JOIN 
    matkul_dosen md ON mkc.id_matkul = md.id_matkul
JOIN 
    dosen d ON md.nip = d.nip
WHERE 
    d.nip = ? AND m.is_tugas = 1;
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_dosen);
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
<h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tugas-tugas kuliah <?php echo $id_matkul_kelas;?></h3>
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
<th scope="col" class="<?php echo $id_hak == 2 ? 'hidden' : '' ?>  p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Nilai</th>
                <th scope="col" class=" p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Status Pengumpulan</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
              <?php foreach ($tugas_tugas as $tugas): ?>
              <tr>
                <td class="p-4 text-sm font-bold text-gray-500 whitespace-nowrap dark:text-gray-400">
                  <?php echo htmlspecialchars($tugas['nama_matkul']); ?>
                </td>
                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                  <?php echo htmlspecialchars($tugas['nama_materi']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($tugas['tenggat']); ?>
                </td>
                <td class="<?php echo $id_hak == 2 ? 'hidden' : '' ?> p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($tugas['nilai']); ?>
                </td>
                <td class="<?php echo $id_hak == 3 ? 'hidden' : '' ?> p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      <span
class="cursor-pointer bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-blue-400 border border-blue-100 dark:border-blue-500">
<?php echo htmlspecialchars($tugas['jumlah_mahasiswa_mengumpulkan']); 
echo '/';
echo htmlspecialchars($tugas['jumlah_mahasiswa']); 
echo ' Mahasiswa'; 
?>
</span>
                </td>
                <td class="<?php echo $id_hak == 2 ? 'hidden' : '' ?> p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
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
</div>

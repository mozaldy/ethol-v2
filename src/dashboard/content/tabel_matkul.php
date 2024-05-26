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
            mkc.id_kelas = ?
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

$mata_kuliah = [];

while ($row = $result->fetch_assoc()) {
    $mata_kuliah[] = $row;
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
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Jadwal</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Ruangan</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">Dosen</th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"></th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
              <?php foreach ($mata_kuliah as $matkul): ?>
              <tr>
                <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($matkul['nama_matkul']); ?>
                </td>
                <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                  <?php echo htmlspecialchars($matkul['hari']); ?>
                  <?php echo htmlspecialchars($matkul['jam']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($matkul['ruang']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <?php echo htmlspecialchars($matkul['nama_dosen']); ?>
                </td>
                <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                  <div class="flex-shrink-0">
<a href="/kuliah/uas/src/dashboard/matkul/detail.php?id=<?php echo $matkul["id_matkul_kelas"] ?>" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
                      Akses Kuliah
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

<?php
// Assuming you have already established a database connection

// Retrieve the id_materi from the GET parameter

// Prepare and execute the SQL query to fetch the required data
$sql = "
SELECT 
    mh.nrp,
    mh.nama,
    CASE 
        WHEN p.id_materi IS NOT NULL THEN 'Sudah Mengumpulkan'
        ELSE 'Belum Mengumpulkan'
    END AS status_pengumpulan,
    COALESCE(p.tanggal_pengumpulan, '-') AS tanggal_pengumpulan,
    COALESCE(p.nilai_tugas, '-') AS nilai_tugas,
p.path_tugas,
p.id_penugasan
FROM 
    mahasiswa mh
JOIN 
    matkul_kelas mkc ON mh.id_kelas = mkc.id_kelas
JOIN 
    materi m ON mkc.id_matkul_kelas = m.id_matkul_kelas
LEFT JOIN 
    pengumpulan_penugasan p ON mh.id_user = p.id_user AND m.id_materi = p.id_materi
WHERE 
    m.id_materi = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_materi);
$stmt->execute();
$result = $stmt->get_result();
?>
  <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Pengumpulan Penugasan:</h2>

    <!-- Table -->
    <div class="flex flex-col mt-6">
      <div class="overflow-x-auto rounded-lg">
        <div class="inline-block min-w-full align-middle">
          <div class="overflow-hidden shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    NRP
                  </th>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Nama
                  </th>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Status Pengumpulan
                  </th>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Tanggal Pengumpulan
                  </th>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Nilai
                  </th>
                  <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800">
                <?php 
                while ($row = $result->fetch_assoc()) : ?>
                  <tr>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo htmlspecialchars($row["nrp"]); ?>
                    </td>
                    <td class="p-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo htmlspecialchars($row["nama"]); ?>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      <span
<?php
if ($row["status_pengumpulan"] === 'Sudah Mengumpulkan') {
echo 'class="cursor-pointer bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">';
}
else {
echo 'class="cursor-pointer bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-red-400 border border-red-100 dark:border-red-500">';
}
  ?>

                      <?php echo htmlspecialchars($row["status_pengumpulan"]); ?>
                      </span>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo htmlspecialchars($row["tanggal_pengumpulan"]); ?>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo htmlspecialchars($row["nilai_tugas"]); ?>
                    </td>
<td class="<?php echo $row["status_pengumpulan"] == 'Sudah Mengumpulkan' ? '' : 'hidden';?> p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
<a href="/kuliah/uas/src/dashboard/tugas/penilaian.php?id=<?php echo $row["id_penugasan"] ?>" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
                Detail
                      <svg class="w-4 h-4 ml-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

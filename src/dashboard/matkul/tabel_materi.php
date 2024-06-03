
    <div>
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Materi-materi kuliah:</h2>

      <!-- Table -->
      <div class="flex flex-col mt-6">
        <div class="overflow-x-auto rounded-lg">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Judul
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
Deskripsi
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
Tanggal Upload
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
Lampiran
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
Action
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
<?php

while ($row = $result_materi->fetch_assoc()) : ?>
                  <tr>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
<?php echo htmlspecialchars($row["nama_materi"]); ?>
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
<?php echo htmlspecialchars($row["deskripsi_materi"]); ?>
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
<?php echo htmlspecialchars($row["uploaded_at"]); ?>
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
<?php echo htmlspecialchars($row["tipe_materi"]); ?>
                    </td>
                    <td class="p-4 whitespace-nowrap">
                      <span
class="cursor-pointer bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500">
<a download href="<?php echo $row["path_materi"] ?>">
Download
</a>
</span>
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

    </div>

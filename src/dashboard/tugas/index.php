
<?php
/** Bruhus
 * **/
$title = "Dashboard | Home";
ob_start();
?>
<div class="px-4 pt-6">
  <div class="grid gap-4">
<?php
require '../content/tabel_tugas.php';
?>
  </div>
</div>
<?php $content = ob_get_clean();
require '../layout.php'; ?>

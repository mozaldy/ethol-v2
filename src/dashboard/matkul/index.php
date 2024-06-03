<?php
include '../utils/guard.php';
$title = "Dashboard | Home";
ob_start();
?>
<div class="px-4 pt-6">
  <div class="grid gap-4">
<?php
include '../content/tabel_matkul.php';
?>
  </div>
</div>
<?php $content = ob_get_clean();
include '../layout.php'; ?>

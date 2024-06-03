<?php
$title = "Dashboard | Home";
include '../utils/guard.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ob_start();
?>
<div class="grid px-4 pt-6 gap-5">
<?php 
include 'content/tabel_matkul.php';
include 'content/tabel_tugas.php';
?>
</div>
<?php $content = ob_get_clean(); include 'layout.php'; ?>

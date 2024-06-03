<?php
session_start();
if (!isset($_SESSION["email"]))
  header('Location: /kuliah/uas/src/login.php');

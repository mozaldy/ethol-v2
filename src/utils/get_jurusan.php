<?php
include "conn.php";

if (isset($_GET['id_departemen'])) {
    $id_departemen = $_GET['id_departemen'];

    $stmt = $conn->prepare("SELECT id_jurusan, nama_jurusan FROM jurusan WHERE id_departemen = ?");
    $stmt->bind_param("i", $id_departemen);
    $stmt->execute();
    $result = $stmt->get_result();

    $jurusan = [];
    while ($row = $result->fetch_assoc()) {
        $jurusan[] = $row;
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($jurusan);
}
?>

<?php
include "conn.php";

if (isset($_GET['id_jurusan']) && isset($_GET['angkatan'])) {
    $id_jurusan = $_GET['id_jurusan'];
    $angkatan = $_GET['angkatan'];

    $stmt = $conn->prepare("SELECT id_kelas, nama_kelas FROM kelas WHERE id_jurusan = ? AND angkatan = ?");
    $stmt->bind_param("is", $id_jurusan, $angkatan);
    $stmt->execute();
    $result = $stmt->get_result();

    $kelas = [];
    while ($row = $result->fetch_assoc()) {
        $kelas[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($kelas);
}
?>

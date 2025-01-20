<?php
require_once 'db.php';

// Fungsi untuk menyimpan data
function storeLuas($alas, $tinggi) {
    global $conn;

    if (!is_numeric($alas) || $alas < 2 || $alas > 300) {
        return "Alas harus berupa angka antara 2 dan 300.";
    }

    if (!is_numeric($tinggi) || $tinggi < 2 || $tinggi > 300) {
        return "Tinggi harus berupa angka antara 2 dan 300.";
    }

    $result = 0.5 * $alas * $tinggi;

    $stmt = $conn->prepare("INSERT INTO luas (alas, tinggi, result) VALUES (?, ?, ?)");
    $stmt->bind_param("ddd", $alas, $tinggi, $result);

    if ($stmt->execute()) {
        sleep(7);
        return "Data luas segitiga berhasil disimpan!";
    } else {
        return "Terjadi kesalahan: " . $conn->error;
    }
}

// Fungsi untuk mengambil semua data
function getAllLuas() {
    global $conn;

    $result = $conn->query("SELECT * FROM luas ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil data berdasarkan ID
function getLuasById($id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM luas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Fungsi untuk memperbarui data
function updateLuas($id, $alas, $tinggi) {
    global $conn;

    if (!is_numeric($alas) || $alas < 2 || $alas > 300) {
        return "Alas harus berupa angka antara 2 dan 300.";
    }

    if (!is_numeric($tinggi) || $tinggi < 2 || $tinggi > 300) {
        return "Tinggi harus berupa angka antara 2 dan 300.";
    }

    $result = 0.5 * $alas * $tinggi;

    $stmt = $conn->prepare("UPDATE luas SET alas = ?, tinggi = ?, result = ? WHERE id = ?");
    $stmt->bind_param("dddi", $alas, $tinggi, $result, $id);

    if ($stmt->execute()) {
        sleep(7);
        return "Data luas segitiga berhasil diubah!";
    } else {
        return "Terjadi kesalahan saat mengubah data: " . $conn->error;
    }
}

// Fungsi untuk menghapus data
function destroyLuas($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM luas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return "Data luas segitiga berhasil dihapus!";
    } else {
        return "Terjadi kesalahan saat menghapus data: " . $conn->error;
    }
}

function getLuasHistory() {
    // Koneksi database
    require 'db.php';
    $query = "SELECT * FROM luas ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    $history = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }
    return $history;
}

?>

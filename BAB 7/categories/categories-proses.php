<?php
require '../koneksi.php';

// === FUNGSI UPLOAD GAMBAR (SUDAH 100% BERHASIL) ===
function upload() {
    if (!is_dir('../img_categories')) {
        mkdir('../img_categories', 0755, true);
    }

    $file = $_FILES['photo'];
    if ($file['error'] !== 0) {
        echo "<script>alert('Pilih gambar dulu!'); window.location='categories-entry.php';</script>";
        return false;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $valid = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $valid)) {
        echo "<script>alert('Hanya boleh JPG, JPEG, PNG, GIF!'); window.location='categories-entry.php';</script>";
        return false;
    }

    $namaBaru = uniqid('cat_') . '.' . $ext;
    $tujuan = '../img_categories/' . $namaBaru;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        return $namaBaru;
    } else {
        echo "<script>alert('Gagal upload gambar!'); window.location='categories-entry.php';</script>";
        return false;
    }
}

// === TAMBAH KATEGORI ===
if (isset($_POST['simpan'])) {
    $categories  = trim($_POST['categories'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $photo       = upload();

    if (!$photo || empty($categories) || empty($price) || empty($description)) {
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO tb_categories (photo, nama_categories, price, description) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$photo, $categories, $price, $description])) {
        echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='categories.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah kategori!'); window.location='categories-entry.php';</script>";
    }
}

// === EDIT KATEGORI ===
elseif (isset($_POST['edit'])) {
    $id          = $_POST['id'];
    $categories  = trim($_POST['categories']);
    $price       = trim($_POST['price']);
    $description = trim($_POST['description']);
    $photoLama   = $_POST['photoLama'] ?? '';

    if ($_FILES['photo']['error'] === 4) {
        $photo = $photoLama;
    } else {
        $photo = upload();
        if ($photo && $photoLama && file_exists("../img_categories/$photoLama")) {
            unlink("../img_categories/$photoLama");
        }
    }

    $stmt = $pdo->prepare("UPDATE tb_categories SET photo = ?, nama_categories = ?, price = ?, description = ? WHERE id_categories = ?");
    if ($stmt->execute([$photo, $categories, $price, $description, $id])) {
        echo "<script>alert('Kategori berhasil diupdate!'); window.location='categories.php';</script>";
    } else {
        echo "<script>alert('Gagal update!'); window.location='categories-edit.php?id=$id';</script>";
    }
}

// === HAPUS KATEGORI (via proses.php juga boleh, atau tetap pakai hapus.php) ===
elseif (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("SELECT photo FROM tb_categories WHERE id_categories = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetchColumn();

    $stmt = $pdo->prepare("DELETE FROM tb_categories WHERE id_categories = ?");
    if ($stmt->execute([$id])) {
        if ($photo && file_exists("../img_categories/$photo")) {
            unlink("../img_categories/$photo");
        }
        echo "<script>alert('Kategori berhasil dihapus!'); window.location='categories.php';</script>";
    }
}

else {
    header("Location: categories.php");
    exit;
}
?>
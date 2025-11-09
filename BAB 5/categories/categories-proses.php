<?php
// File: categories/categories-proses.php
// Fungsi: Proses CRUD Kategori via AJAX + localStorage
// Bisa diganti ke MySQL nanti

header('Content-Type: application/json');

// Simulasi delay (opsional)
usleep(200000); // 0.2 detik

$action = $_GET['action'] ?? '';
$cats = json_decode(file_get_contents('php://input'), true) ?: [];

// Baca data dari localStorage (simulasi server-side)
function getCategories() {
    return json_decode(file_get_contents(__DIR__ . '/categories-data.json'), true) ?: [];
}

function saveCategories($data) {
    file_put_contents(__DIR__ . '/categories-data.json', json_encode($data, JSON_PRETTY_PRINT));
}

// Buat file JSON jika belum ada
if (!file_exists(__DIR__ . '/categories-data.json')) {
    saveCategories([]);
}

switch ($action) {

    // === TAMBAH KATEGORI ===
    case 'add':
        if (empty($cats['name'])) {
            echo json_encode(['success' => false, 'message' => 'Nama kategori wajib diisi!']);
            exit;
        }

        $all = getCategories();
        $all[] = [
            'id' => time(),
            'name' => htmlspecialchars(trim($cats['name'])),
            'created_at' => date('Y-m-d')
        ];
        saveCategories($all);

        echo json_encode(['success' => true, 'message' => 'Kategori ditambahkan!']);
        break;

    // === EDIT KATEGORI ===
    case 'edit':
        if (empty($cats['id']) || empty($cats['name'])) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap!']);
            exit;
        }

        $all = getCategories();
        foreach ($all as &$cat) {
            if ($cat['id'] == $cats['id']) {
                $cat['name'] = htmlspecialchars(trim($cats['name']));
                saveCategories($all);
                echo json_encode(['success' => true, 'message' => 'Kategori diperbarui!']);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan!']);
        break;

    // === HAPUS KATEGORI ===
    case 'delete':
        if (empty($cats['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID wajib diisi!']);
            exit;
        }

        $all = getCategories();
        $filtered = array_filter($all, fn($c) => $c['id'] != $cats['id']);
        saveCategories(array_values($filtered));

        echo json_encode(['success' => true, 'message' => 'Kategori dihapus!']);
        break;

    // === AMBIL SEMUA KATEGORI ===
    case 'list':
        $all = getCategories();
        usort($all, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
        echo json_encode(['success' => true, 'data' => $all]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenali!']);
}
?>
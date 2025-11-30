<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="assets/icon.png" />
    <title>Pertanian Indonesia</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo"><img src="assets/logo.png" alt="" /></div>
                <input type="checkbox" id="click" />
                <label for="click" class="menu-btn"><i class="fas fa-bars"></i></label>
                <ul>
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="login.php" class="btn_login">Login Admin</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="jumbotron">
                <div class="jumbotron-text">
                    <h1>Produk Pertanian Segar</h1>
                    <p>Dari petani langsung ke rumah Anda</p>
                    <button class="btn_getStarted">Pesan Sekarang</button>
                </div>
                <div class="jumbotron-img">
                    <img src="assets/jumbotron.png" alt="" />
                </div>
            </div>

            <div class="cards-categories">
                <h2>Kategori Tanaman</h2>
                <div class="card-categories">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM tb_categories ORDER BY id_categories DESC");
                    if ($stmt->rowCount() == 0) {
                        echo "<h3 style='text-align:center;color:#999;'>Belum ada produk</h3>";
                    }
                    while ($data = $stmt->fetch()) {
                        $foto = $data['photo'] ? "img_categories/{$data['photo']}" : "assets/no-image.jpg";
                        echo "
                        <div class='card'>
                            <div class='card-image'>
                                <img src='$foto' alt='{$data['nama_categories']}' />
                            </div>
                            <div class='card-content'>
                                <h5>{$data['nama_categories']}</h5>
                                <p class='description'>{$data['description']}</p>
                                <p class='price'>Rp " . number_format($data['price']) . "/kg</p>
                                <button class='btn_belanja' onclick='bukaModal({$data['id_categories']})'>Beli</button>
                            </div>
                        </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Modal 1 & Modal 2 tetap seperti punya kamu -->
            <!-- JavaScript tetap sama, hanya fix bukaModal -->

        </main>
        <footer><h4>&copy; Pertanian Indonesia 2025</h4></footer>
    </div>

    <script>
        function bukaModal(id) {
            $.get("get_kategori.php?id=" + id, function(res) {
                var data = JSON.parse(res);
                $("#category_id").val(id);
                $("#category_name").val(data.categories);
                $("#price").val(data.price);
                $("#myModal").css("display", "flex");
            });
        }

        function bukaModal2() {
            tutupModal();
            $("#detail-kategori").val($("#category_name").val());
            $("#detail-harga").val($("#price").val());
            $("#detail-nama").val($("#recipient-name").val());
            $("#detail-nomor").val($("#handphone").val());
            $("#detail-alamat").val($("#alamat-text").val());
            $("#myModal2").css("display", "flex");
        }

        function tutupModal() { $("#myModal").css("display", "none"); }
        function tutupModal2() { $("#myModal2").css("display", "none"); }
        function kembaliKeModalPertama() { tutupModal2(); $("#myModal").css("display", "flex"); }
    </script>
</body>
</html>
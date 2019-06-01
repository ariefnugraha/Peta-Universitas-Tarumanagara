<?php
    include "config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peta Universitas Tarumanagara</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="index.php"><img src="asset/untar.png"></a>
    </nav>
    <main class="container">
        <section class="findroute">
            <div class="row">
                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form">
                    <p class="error"></p>
                    <?php
                        session_start();
                        if(isset($_SESSION['error'])) {
                            echo '<p class="failed">'.$_SESSION['error'].'</p>';
                        }
                    ?>
                    <form method="post" action="dijkstra.php">
                        <div class="form-group">
                            <select id="location" class="form-control" name="location" onchange="validasi()" required>
                                <option value="blank" disabled selected>Pilih Lokasimu...</option>
                                <?php
                                    $location = mysqli_query($conn, "SELECT id, nama FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($location)) {
                                        echo '
                                            <option value="'.$row['id'].'">'.$row['nama'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="destination" class="form-control" name="destination" onchange="validasi()" required>
                                <option value="blank" disabled selected>Pilih Tujuanmu...</option>
                                <?php
                                    $location = mysqli_query($conn, "SELECT id, nama FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($location)) {
                                        echo '
                                            <option value="'.$row['id'].'">'.$row['nama'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn">cari rute</button>
                    </form>
                </section>
                <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 illustration">
                    <h3>selamat datang di universitas tarumanagara</h3>
                    <p class="subtitle">pilih lokasi dan tujuanmu di universitas tarumanagara</p>
                    <img src="asset/main.svg" class="img-responsive">
                </section>
            </div>
        </section>
    </main>
    <section class="info container-fluid">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-4 col-xl-4 info-content">
                <div class="icon">
                    <i class="fas fa-street-view fa-5x"></i>
                </div>
                <h3>pilih lokasimu</h3>
                <p>tentukan lokasi kamu berada</p>
            </section>

            <section class="col-xs-12 col-sm-12 col-md-4 col-xl-4 info-content">
                <div class="icon">
                    <i class="fas fa-map-marker-alt fa-5x"></i>
                </div>
                <h3>pilih tujuanmu</h3>
                <p>tentukan lokasi tujuan yang kamu inginkan</p>
            </section>

            <section class="col-xs-12 col-sm-12 col-md-4 col-xl-4 info-content">
                <div class="icon">
                    <i class="fas fa-route fa-5x"></i>
                </div>
                <h3>ikuti rute</h3>
                <p>setelah itu, kamu hanya perlu ikuti rute yang telah kami sediakan</p>
            </section>
        </div>
    </section>
    <footer class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 web">
                <p class="title">Universitas Tarumangara</p>
                <div class="link">
                    <p><a href="https://www.untar.ac.id">Website untar</a></p>
                    <p><a href="#">tentang kami</a></p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 contact">
                <p><i class="fas fa-map-marker-alt"></i> Jl. Letjen S. Parman No. 1 Jakarta Barat 11440, Indonesia</p>
                <p><i class="fas fa-phone"></i> +62 21 569 58 723 (Hunting)</p>
                <p><i class="fab fa-whatsapp fa-lg"></i> +62 811 7579 727 (Whatsapp Admisi)</p>
                <p><i class="fas fa-envelope fa-lg"></i> humas@untar.ac.id</p>  
            </div>
        </div>
    </footer>
    <script src="js/index.js"></script>
</body>
</html>
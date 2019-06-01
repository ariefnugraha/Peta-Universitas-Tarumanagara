<?php
    include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body id="body" oncscroll="scrolling()">
    <div class="wrapper">
        <nav class="sidebar">
            <img src="asset/untar.png">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" data-toggle="pill" data  href="#alldata"><i class="fas fa-list-alt"></i> <p>semua data</p></a></li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#addbuilding"><i class="fas fa-landmark"></i><p>tambah gedung</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#addroute"><i class="fas fa-directions"></i><p>tambah rute</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#addinfo"><i class="fas fa-info-circle"></i><p>tambah informasi</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#settings"><i class="fas fa-cog"></i><p>pengaturan</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><p>logout</p></a>
                </li>
            </ul>
        </nav>
        <div class="content">
            <div class="tab-content">
                <section id="alldata" class="tab-pane container active">
                    <section class="row tab-pane container active">
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                            <section class="card">
                                <p>banyak gedung</p>
                                <?php
                                    $query = mysqli_query($conn,"SELECT COUNT(*) AS gedung FROM gedung");
                                    while($row = mysqli_fetch_assoc($query)) {
                                        echo '<h3>'.$row['gedung'].'</h3>';
                                    }
                                ?>
                            </section>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 info">
                            <section class="card">
                                <p>total jarak</p>
                                <?php
                                    $query = mysqli_query($conn,"SELECT SUM(jarak) AS jarak FROM jarak");
                                    while($row = mysqli_fetch_assoc($query)) {
                                        echo '<h3>'.$row['jarak'].' meter</h3>';
                                    }
                                ?>
                            </section>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 info">
                            <section class="card">
                                <p>total rute</p>
                                <?php
                                    $query = mysqli_query($conn,"SELECT COUNT(*) AS rute FROM jarak");
                                    while($row = mysqli_fetch_assoc($query)) {
                                        echo '<h3>'.$row['rute'].'</h3>';
                                    }
                                ?>
                            </section>
                        </div>
                    </section>
                    <hr>
                    <section class="route">
                        <p class="title">daftar rute perjalanan universitas tarumanagara</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>asal</th>
                                    <th>tujuan</th>
                                    <th>jarak</th>
                                </tr>
                                <?php
                                    $route = mysqli_query($conn,"SELECT (SELECT nama FROM gedung WHERE jarak.asal = gedung.id) AS asal, (SELECT nama FROM gedung WHERE jarak.tujuan = gedung.id) AS tujuan, jarak FROM jarak ORDER BY asal, tujuan");
                                    while($row = mysqli_fetch_assoc($route)) {
                                        echo '
                                            <tr>
                                                <td>'.$row['asal'].'</td>
                                                <td>'.$row['tujuan'].'</td>
                                                <td>'.$row['jarak'].'</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </table>
                        </div>
                    </section>
                    <hr>
                    <section class="building">
                        <p class="title">daftar gedung universitas tarumanagara</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Gedung</th>
                                </tr>
                                <?php
                                    $building = mysqli_query($conn,"SELECT * FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($building)) {
                                        echo '
                                            <tr>
                                                <td>'.$row['id'].'</td>
                                                <td>'.$row['nama'].'</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </table>
                        </div>
                    </section>
                </section>
                <section id="addbuilding" class="tab-pane container fade">
                    <p class="title">tambah gedung</p>
                    <form method="post" action="addbuilding.php">
                        <div class="form-group">
                            <label>masukkan nama gedung</label>
                            <input type="text" class="form-control" name="building" placeholder="Contoh : Gedung Z" required>
                        </div>
                        <button type="submit" class="btn">tambah gedung</button>
                    </form>
                    
                </section>
                <section id="addroute" class="tab-pane container fade">
                    <p class="title">tambah rute</p>
                    <form method="post" action="addroute.php">
                        <div class="form-group">
                            <label>masukkan asal</label>
                            <select name="asal" class="form-control" required>
                                <option value="" disabled selected>Pilih Asal</option>
                                <?php
                                    $location = mysqli_query($conn,"SELECT * FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($location)) {
                                        echo '
                                            <option value="'.$row['id'].'">'.$row['nama'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>masukkan tujuan</label>
                            <select name="tujuan" class="form-control" required>
                                <option value="" selected disabled>Pilih tujuan</option>
                                <?php
                                    $location = mysqli_query($conn,"SELECT * FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($location)) {
                                        echo '
                                            <option value="'.$row['id'].'">'.$row['nama'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>masukkan jarak (dalam meter)</label>
                            <input type="number" class="form-control" name="jarak" placeholder="Jarak..." required> 
                        </div>
                        <button type="submit" class="btn">tambah rute</button>
                    </form>
                </section>
                <section id="addinfo" class="tab-pane container fade">
                    <p class="title">tambah informasi</p>
                    <form method="post" action="addinfo.php">
                        <div class="form-group">
                            <label>Pilih Gedung</label>
                            <select name="building" class="form-control" required>
                                <option value="" disabled selected>Pilih Gedung</option>
                                <?php
                                    $location = mysqli_query($conn,"SELECT * FROM gedung ORDER BY id");
                                    while($row = mysqli_fetch_assoc($location)) {
                                        echo '
                                            <option value="'.$row['id'].'">'.$row['nama'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>masukkan informasi</label>
                            <input type="text" class="form-control" name="info" placeholder="Contoh : Perpustakaan, Fakultas Pertanian" required>
                        </div>
                        <button type="submit" class="btn">Tambah informasi</button>
                    </form>
                </section>
                <section id="setting" class="tab-pane container fade">

                </section>
            </div>
    
            <div id="to-top">
                <p onclick="toTop()"><i class="fas fa-arrow-up fa-lg"></i></p>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
</body>
</html>
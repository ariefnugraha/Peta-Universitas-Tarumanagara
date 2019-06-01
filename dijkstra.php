<?php
include "config.php";

//the start and the end
$location = mysqli_real_escape_string($conn, $_POST['location']);
$destination = mysqli_real_escape_string($conn, $_POST['destination']);

//VALIDASI FORM
if ($location == $destination) {
    session_start();
    $_SESSION['error'] = "Lokasi dan Tujuan Tidak Boleh Sama";
    header("location:index.php");
}

//QUERY
$semuaData = mysqli_query($conn, "SELECT * FROM jarak ORDER BY asal,jarak");
$jumlahData = mysqli_query($conn, "SELECT COUNT(*) AS jarak FROM jarak ORDER BY asal,jarak");
$DataTerakhir = mysqli_query($conn, "SELECT * FROM jarak ORDER BY id DESC");


//FETCH QUERY
$countFetch = mysqli_fetch_assoc($jumlahData);
$getLength = $countFetch['jarak'];


$arr = array();
$simpanData = array();

//AMBIL DATA TERAKHIR
while ($row = mysqli_fetch_assoc($DataTerakhir)) {
    $object = new stdClass();
    $object->jarak = $row['jarak'];
    $object->asal = $row['asal'];
    $object->tujuan = $row['tujuan'];
    array_push($simpanData, $object);
}

//AMBIL SEMUA DATA KECUALI TERAKHIR
while ($row = mysqli_fetch_assoc($semuaData)) {
    $object = new stdClass();
    $object->jarak = $row['jarak'];
    $object->asal = $row['asal'];
    $object->tujuan = $row['tujuan'];
    array_push($arr, $object);
}

array_push($simpanData, $arr);

$_distArr = array();
$i = 0;
while ($i < count($simpanData) - 1) {
    $_distArr[$simpanData[$i]->asal][$simpanData[$i]->tujuan] = $simpanData[$i]->jarak;
    $i++;
}

//initialize the array for storing
$S = array(); //the nearest path with its parent and weight
$Q = array(); //the left nodes without the nearest path

//foreach (array_keys($_distArr) as $val) $Q[$val] = 99999;
$Q[$location] = 0;

$i = 0;
$posisi = $location;

/*
while ($posisi <= $destination) {
    array_push($S, $posisi);
    $posisi++;
}
*/


$posisi = $location;
$Q = array();

//KALKULASI RUTE
while ($posisi != $destination) {
    if ($posisi < $destination) {
        for ($j = 0; $j < count($simpanData) - 1; $j++) {
            if ($simpanData[$j]->tujuan == $posisi + 1) {
                array_push($Q, $simpanData[$j]);
                break;
            }
        }
        $posisi++;
    } else if ($posisi > $destination) {
        for ($j = 0; $j < count($simpanData) - 1; $j++) {
            if ($simpanData[$j]->tujuan == $posisi - 1) {
                array_push($Q, $simpanData[$j]);
                break;
            }
        }
        $posisi--;
    }
}

$totalJarak = 0;
for ($k = 0; $k < count($Q); $k++) {
    $totalJarak += $Q[$k]->jarak;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rute | Universitas Tarumanagara</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dijkstra.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body onload="tambahclass()">
    <main class="container">
        <section class="info">
            <?php
            //$tempat = implode(",",$Q->tujuan);
            $place = mysqli_query($conn, "SELECT nama FROM gedung WHERE id IN ($location)");
            echo '<p class="title">';
            while ($placeFetch = mysqli_fetch_assoc($place)) {
                echo $placeFetch['nama'] . ' <i class="fas fa-arrow-right"></i> ';
            }

            echo '</p><hr>';
            echo '<small>Jarak</small>';
            $totalJarak = 0;
            for ($k = 0; $k < count($Q); $k++) {
                echo $Q[$k]->tujuan;
            }

            echo '<p>';
            echo $totalJarak;
            echo ' meter</p>';
            ?>
        </section>
        <!--
        <section class="route">
            <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="0">
    
                <?php
                $place = mysqli_query($conn, "SELECT (SELECT image FROM image WHERE image.id = gedung.id) AS image FROM gedung WHERE id BETWEEN '$location' AND '$destination'");
                $jumlahData = mysqli_num_rows($place);

                echo '<ul class="carousel-indicators">';
                for ($i = 0; $i <= $jumlahData; $i++) {
                    echo '<li data-target="carousel" data-slide-to="' . $i . '"></li>';
                }
                echo '</ul>';

                echo '<div id="carousel-inner" class="carousel-inner">';
                while ($row = mysqli_fetch_assoc($place)) {
                    echo '
                        <div class="carousel-item">
                            <iframe src="' . $row['image'] . '"></iframe>
                        </div>
                    ';
                }
                echo '</div>';
                ?>



            </div>
            <div class="carousel-handler">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a class="carousel-control-prev" href="#carousel" data-slide="prev"><i class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a class="carousel-control-next" href="#carousel" data-slide="next"><i class="fas fa-arrow-right fa-2x"></i></a>
                    </div>
                </div>

            </div>
            <a class="done" href="thankyou.php">Saya sudah tiba di tujuan</a>
        </section>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/dijkstra.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
            -->
</body>

</html>
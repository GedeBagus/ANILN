<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="text/css" href=css/style.css>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">




  <title>ANILN</title>
</head>

<body>
  <!-- Navbar -->

  <head>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="index.php">ANILN <b>OTAKU</b></a>
        </button>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link">More Than Just Otaku</a>
          </li>
        </ul>
      </nav>
    </div>
  </head>
  <?php
  require_once("sparqllib.php");

  $test = $_POST['search-aniln'];
  $data = sparql_get(
    "http://localhost:3030/test",
    "
      PREFIX p: <http://Aniln.com>
      PREFIX d: <http://Aniln.com/ns/data#>
      
      SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penerbit ?Status ?JumlahEps
      WHERE
      { 
          ?s  d:nama ?Nama;
              d:jenis ?Tipe;
              d:sinopsis ?Sinopsis;
              d:airedPublished ?Rilis;
              d:studiosAuthor ?Penerbit;
              d:status ?Status;
              d:episodeChapter ?JumlahEps
              FILTER regex(?Nama, '$test')
  
      }
          "
  );
  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  var_dump($test);
  // $search = $_POST['search-aniln'];
  //         var_dump($search);
  ?>

  <!-- Jumbotron-->
  <section class="jumbotron-bg">
    <div class="jumbotron  warna-bg">
    </div>
  </section>

  <!-- Form Search -->
  <div class="main">
    <div class="container">
      <div class="shadow mb-5 bg-white rounded layout">
        <div class="form-group has-search">
          <form action="" method="post" id="nameform">
            <div class="input-group">
              <span class="fa fa-search fa-1x form-control-feedback"></span>
              <input type="text" name="search-aniln" class="form-control form-control-lg " placeholder="Search Anime or Light Novel">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="submit"> Search
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Opsi dua -->
  <div class="konten">
    <!--
            CREATE PAGE IN TABLE FORM
            <table class="table table-bordered table-hover">
            <thead class="thead-light">
            <?php
            print "<tr>";
            foreach ($data->fields() as $field) {
              print "<th>$field</th>";
            }
            print "</tr>";
            print "</thead>";

            print "<tbody>";
            foreach ($data as $row) {
              print "<tr>";
              foreach ($data->fields() as $field) {
                print "<td>$row[$field]</td>";
              }
              print "</tr>";
            }
            print "</tbody>";
            ?>
        </table>-->
    <div class="container">
      <h3>Search Result</h3>
      <p>Search: <span id="nama-db">(Search keyword)</span></p>
      <hr>
      <div class="row">
        <?php foreach ($data as $dat) : ?>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <div class="header-data"> <b><?= $dat['Nama']?></b></div>
                  <div class="item-data" id="nama-db"><b>Onepiece</b></div>
                  <p class="card-text">Gol D. Roger was known as the "Pirate King," the strongest and most infamous being to have sailed the Grand Line. The capture and execution of Roger by the World Government brought a change throughout the world. His last words before his death revealed the existence of the greatest treasure in the world, One Piece. It was this revelation that brought about the Grand Age of Pirates, men who dreamed of finding One Piece—which promises an unlimited amount of riches and fame—and quite possibly the pinnacle of glory and the title of the Pirate King.
                    Enter Monkey D. Luffy, a 17-year-old boy who defies your standard definition of a pirate. Rather than the popular persona of a wicked, hardened, toothless pirate ransacking villages for fun, Luffy's reason for being a pirate is one of pure wonder: the thought of an exciting adventure that leads him to intriguing people and ultimately, the promised treasure. Following in the footsteps of his childhood hero, Luffy and his crew travel across the Grand Line, experiencing crazy adventures, unveiling dark mysteries and battling strong enemies, all in order to reach the most coveted of all fortunes—One Piece.
                  </p>
                  <hr>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="header-data"> <b>Jenis Mata Kuliah :</b>
                    <div class="item-data">Wajib</div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Dosen Pengajar :</b></div>
                  <div class="item-data">Mira Suryani</div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Jumlah SKS :</b></div>
                  <div class="item-data">3</div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Semester :</b></div>
                  <div class="item-data">6</div>
                </li>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <footer>&copy; ANILN Otaku</footer>
  <script>
    // Assign JSON object from PHP to Javascript globally
    localStorage.setItem("json", JSON.stringify(<?php echo json_encode($data, JSON_PRETTY_PRINT); ?>));
    // Get index parameter from URL
    var url_string = window.location.href;
    var url = new URL(url_string);
    var index = url.searchParams.get("index");

    // Get current province's coordinate
    // var lat = JSON.parse(localStorage.getItem("json"))[index].Latitude;
    // var lon = JSON.parse(localStorage.getItem("json"))[index].Longitude;

    // Update HTML elements
    // document.getElementById("nama-provinsi").innerHTML = "Provinsi " + JSON.parse(localStorage.getItem("json"))[index].Positif;
    document.getElementById("nama-db").innerHTML = JSON.parse(localStorage.getItem("json"))[index].Nama;
    // document.getElementById("card-sembuh").innerHTML = JSON.parse(localStorage.getItem("json"))[index].Sembuh;
    // document.getElementById("card-meninggal").innerHTML = JSON.parse(localStorage.getItem("json"))[index].Meninggal;

    // Update Best Province
    // document.getElementById("firstProvince").innerHTML = JSON.parse(localStorage.getItem("json"))[bestProvinceIndex[0]].Provinsi;
    // document.getElementById("firstProvince").href = 'info.php?index=' + bestProvinceIndex[0];
    // document.getElementById("secondProvince").innerHTML = JSON.parse(localStorage.getItem("json"))[bestProvinceIndex[1]].Provinsi;
    // document.getElementById("secondProvince").href = 'info.php?index=' + bestProvinceIndex[1];
    // document.getElementById("thirdProvince").innerHTML = JSON.parse(localStorage.getItem("json"))[bestProvinceIndex[2]].Provinsi;
    // document.getElementById("thirdProvince").href = 'info.php?index=' + bestProvinceIndex[2];
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    color: #515155;
  }

  .my-auto p {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    text-align: center;
    font-size: 2rem;
    color: white;
  }

  .warna-bg {
    background: url(asset/ANILN.png);
    background-size: 100% 100%;
    height: 620px;
  }

  .has-search .form-control {
    padding-left: 2.375rem;
  }

  .has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
    margin-top: 5px
  }

  .form-control {
    background-color: white;
    border: 0;
  }

  .layout {
    margin-top: -60px;
  }

  .header-data {
    padding-right: 15px;
    justify-content: space-between;
    font-weight: 500;
    letter-spacing: 2%;
  }

  .item-data {
    padding-right: 15px;
    justify-content: space-between;
    font-weight: 400;
    letter-spacing: 2%;
  }

  .data {
    line-height: 30px;
    padding-bottom: 10px;
  }

  .card {
    margin-bottom: 40px;
    border-radius: 10px;
  }
</style>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="text/css" href=css/style.css>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>ANILN</title>
</head>

<body>
  <head>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="home.php">ANILN <b>OTAKU</b></a>
        </button>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="aboutus.php">About Us</a>
          </li>
        </ul>
      </nav>
    </div>
  </head>
  <?php
  require_once("sparqllib.php");
  $test = "";
  if (isset($_POST['search-aniln'])) {
    $test = $_POST['search-aniln'];
    $data = sparql_get(
      "http://localhost:3030/aniln",
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
  } else {
    $data = sparql_get(
      "http://localhost:3030/aniln",
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
    
        }
            "
    );
  }

  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  //var_dump($test);
  // $search = $_POST['search-aniln'];
  //         var_dump($search);
  ?>

  <div class="jumbotron jumbotron warna-bg">
  </div>

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

  <div class="konten">
    <div class="container">
      <h3>Search Result</h3>
      <p>Search: <span>
          <?php
          if ($test != NULL) {
            echo $test;
          } else {
            echo "Search Keyword";
          }
          ?></span></p>
      <hr>
      <div class="row">
        <?php foreach ($data as $dat) : ?>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <div class="header-data"> <b>Name : </b></div>
                  <div class="item-data" id="nama-db"><b><?= $dat['Nama'] ?></b></div>
                  <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Sinopsis
                          </button>
                        </h2>
                      </div>
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                          <?= $dat['Sinopsis'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="header-data"> <b>Anime or Light Novel :</b>
                    <div class="item-data"><?= $dat['Tipe'] ?></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Status :</b></div>
                  <div class="item-data"><?= $dat['Status'] ?></div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Release Date :</b></div>
                  <div class="item-data"><?= $dat['Rilis'] ?></div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Studios or Author :</b></div>
                  <div class="item-data"><?= $dat['Penerbit'] ?></div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Episode or Chapters :</b></div>
                  <div class="item-data"><?= $dat['JumlahEps'] ?></div>
                </li>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <footer>&copy; ANILN Otaku</footer>
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
    background: url(asset/ANILN2.png);
    background-size: 100% 100%;
    height: 440px;
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
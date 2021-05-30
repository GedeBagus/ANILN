<?php
 require_once("sparqllib.php");
 $test = "";
 $data_received = json_decode(file_get_contents("php://input"));
 if ($data_received) {
    $test = $data_received->data;
    $data = sparql_get(
      "http://localhost:3030/aniln",
      "
      PREFIX p: <http://Aniln.com>
      PREFIX d: <http://Aniln.com/ns/data#>

      SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penerbit ?Status ?Genre ?Image ?JumlahEps ?Score
      WHERE
      { 
          ?s  d:nama ?Nama;
              d:jenis ?Tipe;
              d:sinopsis ?Sinopsis;
              d:airedPublished ?Rilis;
              d:studiosAuthor ?Penerbit;
              d:status ?Status;
              d:genre ?Genre;
              d:image ?Image;
              d:episodeChapter ?JumlahEps;
              d:score ?Score
              FILTER (regex(?Nama, '$test') || regex(?Tipe, '$test') || regex(?Status,  '$test') || regex(?Genre, '$test'))

      }
                  "
    );
  } else {
    $data = sparql_get(
      "http://localhost:3030/aniln",
      "
      PREFIX p: <http://Aniln.com>
      PREFIX d: <http://Aniln.com/ns/data#>

      SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penerbit ?Status ?Genre ?JumlahEps ?Image ?Score
      WHERE
      { 
          ?s  d:nama ?Nama;
              d:jenis ?Tipe;
              d:sinopsis ?Sinopsis;
              d:airedPublished ?Rilis;
              d:studiosAuthor ?Penerbit;
              d:status ?Status;
              d:genre ?Genre;
              d:image ?Image;
              d:episodeChapter ?JumlahEps;
              d:score ?Score
      }
                  "
    );
  }
  echo json_encode($data);
?>
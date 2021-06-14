<?php
 require_once("sparqllib.php");
 $test = "";
 
 $data_received = json_decode(file_get_contents("php://input"));
 if ($data_received) {
   $data = [];
   if(strpos($data_received->data," ") !== false){
    $datArray = explode(" ",$data_received->data);
    foreach($datArray as $singleData){
      $test = $data_received->data;
      $data_temp = sparql_get(
      "http://localhost:3030/aniln",
      "
      PREFIX p: <http://Aniln.com>
      PREFIX d: <http://Aniln.com/ns/data#>

      SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penerbit ?Status ?Genre ?Image ?JumlahEps ?Score
      WHERE
      { 
        ?s  d:nama ?Nama;
        d:sinopsis ?Sinopsis;
        d:airedPublished ?Rilis;
        d:studiosAuthor ?Penerbit;
        d:status ?Status;
        d:genre ?Genre;
        d:image ?Image;
        d:episodeChapter ?JumlahEps;
        d:score ?Score.
  ?t 	d:jenis ?Tipe;
  d:isJenis ?s.
              FILTER (regex(?Nama, '$singleData','i') || regex(?Tipe, '$singleData','i') || regex(?Status,  '$singleData','i') || regex(?Genre, '$test','i'))

      }
                  "
    );
    if(array_key_exists(0,$data_temp) && !in_array($data_temp[0],$data)){
      $data[] = $data_temp[0];
    }
    }
   }else{
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
        d:sinopsis ?Sinopsis;
        d:airedPublished ?Rilis;
        d:studiosAuthor ?Penerbit;
        d:status ?Status;
        d:genre ?Genre;
        d:image ?Image;
        d:episodeChapter ?JumlahEps;
        d:score ?Score.
  ?t 	d:jenis ?Tipe;
  d:isJenis ?s.
              FILTER (regex(?Nama, '$test','i') || regex(?Tipe, '$test','i') || regex(?Status,  '$test','i') || regex(?Genre, '$test','i'))

      }
                  "
    );
  }
} else {
    $data = sparql_get(
      "http://localhost:3030/aniln",
      "
      PREFIX p: <http://Aniln.com>
      PREFIX d: <http://Aniln.com/ns/data#>

      SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penerbit ?Status ?Genre ?Image ?JumlahEps ?Score
      WHERE
      { 
        ?s  d:nama ?Nama;
        d:sinopsis ?Sinopsis;
        d:airedPublished ?Rilis;
        d:studiosAuthor ?Penerbit;
        d:status ?Status;
        d:genre ?Genre;
        d:image ?Image;
        d:episodeChapter ?JumlahEps;
        d:score ?Score.
?t 	d:jenis ?Tipe;
  d:isJenis ?s.
      }
                  "
    );
  }
  
  echo json_encode($data);
?>
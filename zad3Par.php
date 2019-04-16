<?php
 //Učitaj datoteku
$xml = simplexml_load_file('LV2.xml');
//Iteracija kroz XML
foreach ($xml->record as $record) {
    //Ispis podataka
    echo '<img src = "'.$record->slika.'">';
    echo "<div>"."<b>IME:</b>"."$record->ime";
    echo "<div>"."<b>PREZIME:</b>"."$record->prezime";
    echo "<div>"."<b>E-MAIL:</b>"."$record->email";
    echo "<div>"."<b>SPOL:</b>"."$record->spol";
    echo "<div>"."<b>ZIVOTOPIS:</b>"."$record->zivotopis<br><br><br>";
}
?>
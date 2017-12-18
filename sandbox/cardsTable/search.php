<?php
// https://www.w3schools.com/sql/sql_like.asp

$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

if (isset($_GET['s'])) {

  $q = "SELECT name, type, color, img
        FROM card
        WHERE name LIKE '%". $_GET['s'] ."%'";

  $query = $db->prepare($q);
  $result = $query->execute();
  $cards = $query->fetchAll(PDO::FETCH_ASSOC);
  $cards_json = json_encode($cards);
  echo $cards_json; // envoie au client d'une réponse JSON

} else {
  $q = "SELECT name, img, type, color FROM card"; // renvoie la totalité des cartes
  $query = $db->prepare($q);
  $query->execute();
  $cards = $query->fetchAll(PDO::FETCH_ASSOC);
  $cards_json = json_encode($cards);
  echo $cards_json;
}









?>

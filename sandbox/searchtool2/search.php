<?php

// https://www.w3schools.com/sql/sql_like.asp

$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

if (isset($_GET['s'])) {

  $q = "SELECT name, type, color
        FROM card
        WHERE name LIKE '%". $_GET['s'] ."%'";

  $query = $db->prepare($q);
  // $result = $query->execute([
  //   ':s' => $_GET['s']
  // ]);
  $result = $query->execute();

  $cards = $query->fetchAll(PDO::FETCH_OBJ);

  foreach($cards as $card) {
    echo '<p>' . $card->name . '('.$card->type.')</p>';
  }

} else {
  echo 'Recherche incorrecte';
}









?>

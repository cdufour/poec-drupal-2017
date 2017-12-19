<?php
// https://www.w3schools.com/sql/sql_like.asp

$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

// table de correspondance pour la gestion de la traduction
$voca = [
  'creature'        => ['fr' => 'Créature', 'it' => 'Creatura'],
  'sorcery'         => ['fr' => 'Rituel'],
  'enchantement'    => ['fr' => 'Enchantement'],
  'red'             => ['fr' => 'Rouge'],
  'green'           => ['fr' => 'Vert'],
  'blue'            => ['fr' => 'bleu'],
  'black'           => ['fr' => 'Noire'],
  'white'           => ['fr' => 'Blanc'],
  'multicolor'      => ['fr' => 'Multicolore']
];

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
  $q = "SELECT id, name, type, color, popularity FROM card ORDER BY name ASC"; // renvoie la totalité des cartes
  $query = $db->prepare($q);
  $query->execute();
  $cards = $query->fetchAll(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // print_r($cards);
  // echo '</pre>';

  $c = [];
  // ajout des traductions
  $cards_translated = [];

  foreach($cards as $card) {
    $c = [];
    $c = $card;

    $type_fr  = $voca[$card['type']]['fr'];
    $color_fr = $voca[$card['color']]['fr'];

    $c['type_fr']   = $type_fr;
    $c['color_fr']  = $color_fr;

    // ajout de la carte dans le tableau
    $cards_translated[] = $c; // syntaxe alternative : array_push($cards_translated, $c);

  }

  // echo '<pre>';
  // print_r($cards_translated);
  // echo '</pre>';


  $cards_json = json_encode($cards_translated);
  echo $cards_json;
}









?>

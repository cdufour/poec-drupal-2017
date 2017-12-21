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
  $q = "SELECT card.id, card.name, type, color, popularity, img,
        edition.name AS edition, edition.date_start, edition.date_end,
        UPPER(illustrator.lastname) AS illustrator
        FROM card
        INNER JOIN edition ON card.edition_id = edition.id
        LEFT JOIN illustrator ON card.illustrator_id = illustrator.id
        ORDER BY name ASC";

  $query = $db->prepare($q);
  $query->execute();
  $cards = $query->fetchAll(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // print_r($cards);
  // echo '</pre>';

  $c = [];
  // ajout des traductions
  $cards_modified = [];

  foreach($cards as $card) {
    $c = [];
    //$c = $card;
    $c['id'] = $card['id'];
    $c['name'] = $card['name'];
    $c['type'] = $card['type'];
    $c['color'] = $card['color'];
    $c['popularity'] = $card['popularity'];
    $c['img'] = $card['img'];

    // si la carte n'a pas d'illustrateur
    // on lui donne la valeur "Inconnu" (au lieu de null)
    $c['illustrator'] = ($card['illustrator'] == null)
      ? 'Inconnu'
      : $card['illustrator'];

    // mise en haut de casse par php (inutile si fait avec SQL)
    //$c['illustrator'] = strtoupper($card['illustrator']);

    $c['edition'] = [
      'name' => $card['edition'],
      'date_start' => $card['date_start'],
      'date_end' => $card['date_end']
    ];

    $type_fr  = $voca[$card['type']]['fr'];
    $color_fr = $voca[$card['color']]['fr'];

    $c['type_fr']   = $type_fr;
    $c['color_fr']  = $color_fr;

    // ajout de la carte dans le tableau
    $cards_modified[] = $c; // syntaxe alternative : array_push($cards_translated, $c);

  }

  // echo '<pre>';
  // print_r($cards_translated);
  // echo '</pre>';


  $cards_json = json_encode($cards_modified);
  echo $cards_json;
}









?>

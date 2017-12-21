<?php
$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

// requête SQL
$q =
  " UPDATE card
    SET popularity = :popularity
    WHERE id = :card_id
  ";
$query = $db->prepare($q);
$result = $query->execute([
  ':popularity' => intval($_POST['popularity']),
  ':card_id' => intval($_POST['id'])
]);

$res = [
  'result' => $result,
  'message' => 'Tout va bien'
];

echo json_encode($res);

?>

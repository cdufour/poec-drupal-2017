<?php
// https://openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/memento-des-expressions-regulieres
$proverb = "Il ne <em> faut pas mettre 56 charrues</em>et <em>4 roues</em> avant 23 2 voitures";
//$pattern = "/la/"; // la
$pattern = "/\d\d/"; // 41
$pattern = "/\d+/"; // + => 1 ou plusieurs // 41, 4, 222
$pattern = "/\d{3}/"; // 256
$pattern = "/\d{2} \d{2}/";
//$pattern = "/  /"; // recherche deux espaces consécutifs
// équivalent:
$pattern = "/\s{2}/"; // recherche deux espaces consécutifs
$pattern = "/[A-Z][a-z]/"; // Il
$pattern = "/<em>(\s?\w+\s?)+<\/em>/";// balises incluses dans le match

// (?<=expr) positive lookbehind vérifie la présence de l'expression côté gauche mais ne l'inclut pas dans le match
// (?=expr) positive lookahead vérifie la présence de l'expression côté droit mais ne l'inclut pas dans le match
$pattern = "/(?<=<em>)(\s?\w+\s?)+(?=<\/em>)/";

//preg_match_all($pattern, $proverb, $matches);

// requête de serveur à serveur
//$url = 'http://www.proverbes-francais.fr/proverbes-francais/'; //302
$url = "http://citation-celebre.leparisien.fr/proverbe/francais";
$curl = curl_init($url);

// CURLOPT_RETURNTRANSFER => 1 permet de transfèr la rep HTTP dans une variable
// CURLOPT_RETURNTRANSFER => 0 la rep HTTP remplace le DOM courant

curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => $url
));

$res = curl_exec($curl);
//echo mb_detect_encoding($res);

//echo htmlspecialchars($res);
//echo substr(htmlentities($res), 0, 50);

//$pattern = "/<q><a href=\"http:\/\/citation-celebre.leparisien.fr\/citations\/\d+\"\stitle=\"Voir la source de la citation\">(\s*\w+\'?,?\s*)+/u";

//$pattern = "/(\s*\w+\'?,?\s*)+/u";
//$pattern = "/\p{L}+/ui";
//$pattern = "/\p{L}(\p{L}+[- ']?)*\p{L}/";
//$pattern = "/(\p{L},?[- ']?)+/u";
//$pattern = "/((&ecirc;)?\p{L},?[- ']?)+\.<\/a>/u";
//$pattern = '/emp&ecirc;cher/';
//$pattern = '/\'aboyer/'; //&apos;
$pattern = "/\.*<\/a>/u";
//$res = "Quand la pauvreté entre par la porte, l'amour s'en va par la fenêtre.";
preg_match_all($pattern, $res, $matches);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Expressions Régulières</title>

  </head>
  <body>
    <h1>Expressions Régulières</h1>
  </body>
    <?php
    echo sizeof($matches[0]) . ' correspondances';

    foreach($matches[0] as $match) {
      echo '<p>'. htmlentities($match) .'</p>';
    }
    ?>
</html>

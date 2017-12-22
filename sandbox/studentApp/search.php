<?php
$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

// $q= "SELECT student.lastname, student.firstname,
//   result.note, exam.date, exam.topic
//     FROM result
//     INNER JOIN student ON result.student_id = student.id
//     INNER JOIN exam ON result.exam_id = exam.id";


// table principale: student. Je veux la totalité des étudiants
$q = "SELECT student.lastname, student.firstname,
  result.note, exam.date, exam.topic
      FROM student
      LEFT JOIN result ON student.id = result.student_id
      LEFT JOIN exam ON result.exam_id = exam.id";

$query = $db->prepare($q);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($rows);
echo '</pre>';

// fonction de recherche
function searchStudent($students, $student_lastname) {
  $position = -1;
  for($i=0; $i<sizeof($students); $i++) {
    if ($students[$i]['lastname'] === $student_lastname) {
      $position = $i;
      break; // étudiant trouvé, sortie de boucle
    }
  }
  return $position;
}

$students = []; // tableau vide qui devra être renvoyé au client
foreach($rows as $row) {

 // si l'étudiant n'a pas déjà été traité, il faut
 // l'ajouter au tableau $students
 $position = searchStudent($students, $row['lastname']);

 if ($position === -1) { // étudiant non trouvé
   // création d'un nouvel étudiant
   $student = [
     'lastname' => $row['lastname'],
     'firstname' => $row['firstname'],
     'exams' => []
   ];

   // si l'étudiant a subi un exam
   if ($row['note'] !== null) {
     $student['exams'][] = [
       'date' => $row['date'],
       'topic' => $row['topic']
     ];
   }

   // ajout de l'étudiant au tableau des étudiants
   $students[] = $student;

 } else { // étudiant déjà rencontré

 }

} // fin forEach

echo '<pre>';
print_r($students);
echo '</pre>';

?>

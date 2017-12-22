<?php
$db = new PDO('mysql:host=localhost;dbname=ajax', 'root', 'paris');

//$q = "SELECT * FROM student";

// $q= "SELECT student.lastname, student.firstname,
//   result.note, exam.date, exam.topic
//     FROM result
//     INNER JOIN student ON result.student_id = student.id
//     INNER JOIN exam ON result.exam_id = exam.id";

$q = "SELECT student.lastname, student.firstname,
        result.note, exam.date AS date_exam, exam.topic
      FROM student
      LEFT JOIN result ON student.id = result.student_id
      LEFT JOIN exam ON result.exam_id = exam.id";

$query = $db->prepare($q);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

function findStudent($source, $student) {
  $position = -1;
  for($i=0; $i<sizeof($source); $i++) {
    if ($source[$i]['lastname'] === $student) {
      $position = $i;
      break;
    }
  }
  return $position;
}

//echo findStudent($rows, 'Del Priore');

$students = [];
foreach($rows as $row) {
  $student_position = findStudent($students, $row['lastname']);
  if ($student_position !== -1) { // étudiant trouvé
    if ($row['date_exam'] !== null) {
      $students[$student_position]['exams'][] = [
        'date' => $row['date_exam'],
        'topic' => $row['topic'],
        'note'  => $row['note']
      ];
    }
  } else { // étudiant non trouvé
    $student = [];
    $student['lastname'] = $row['lastname'];
    $student['firstname'] = $row['firstname'];
    if ($row['date_exam'] !== null) {
      $student['exams'][] = [
        'date' => $row['date_exam'],
        'topic' => $row['topic'],
        'note'  => $row['note']
      ];
    }
    $students[] = $student;
  }

}

// echo '<pre>';
// print_r($students);
// echo '</pre>';

echo json_encode($students)

?>

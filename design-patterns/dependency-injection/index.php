<?php
include 'Student.php';

$db = new PDO('mysql:host=localhost;dbname=ajax','root', 'paris');

$query = $db->prepare('SELECT * FROM student');
$result = $query->execute();
$students = $query->fetchAll(PDO::FETCH_OBJ);

$super_student = new Student(
  $students[0]->firstname,
  $students[0]->lastname
);

echo $super_student->getFullname();

echo '<pre>';
print_r($students);
echo '</pre>';

$student1 = new Student('paolo', 'Del Priore');
$student2 = new Student('Manu', 'macron');
$student3 = new Student('Giuseppe', 'Meazza');

// $student3->setFirstname('Paolo');
// $student3->setLastname('Del Priore');
// echo $student3->getFirstname();
// echo $student3->getLastname();

echo $student2->getFullname();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Injection de dépendance</title>
  </head>
  <body>
    <h1>Injection de dépendance</h1>


  </body>
</html>

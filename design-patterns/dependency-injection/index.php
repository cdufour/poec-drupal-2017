<?php
//include 'Student.php';
include 'StudentManager.php';

// l'objet PDO $db est instancié à l'extérieur de la classe StudentManager
// et fourni est entré du constructeur de cette classe.
// cette INJECTION DE DEPENDANCE permet de faire varier le paramètrage
// de l'objet fourni en entrée sans avoir à modifier la classe
// StudentManager elle-même
$db = new PDO('mysql:host=localhost;dbname=ajax','root', 'paris');

// $student_manager = new StudentManager();
// $list = $student_manager->list();
// var_dump($list);

$student_manager = new StudentManager($db);
$students = $student_manager->list();
//var_dump($students);

// $db = new PDO('mysql:host=localhost;dbname=ajax','root', 'paris');
//
// $query = $db->prepare('SELECT * FROM student');
// $result = $query->execute();
// $students = $query->fetchAll(PDO::FETCH_OBJ);
//
// $super_student = new Student(
//   $students[0]->firstname,
//   $students[0]->lastname
// );

//$list = Student::list();

// echo $super_student->getFullname();
//
// echo '<pre>';
// print_r($students);
// echo '</pre>';

// $student1 = new Student('paolo', 'Del Priore');
// $student2 = new Student('Manu', 'macron');
// $student3 = new Student('Giuseppe', 'Meazza');

// $student3->setFirstname('Paolo');
// $student3->setLastname('Del Priore');
// echo $student3->getFirstname();
// echo $student3->getLastname();

//echo $student2->getFullname();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Injection de dépendance</title>
  </head>
  <body>
    <h1>Injection de dépendance</h1>
    <ul>
      <?php
        foreach($students as $student) {
          echo '<li>' . $student->getFullname() . '</li>';
        }
      ?>
    </ul>
  </body>
</html>

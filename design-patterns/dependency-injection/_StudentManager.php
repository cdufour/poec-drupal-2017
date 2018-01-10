<?php
include 'Student.php';

class StudentManager {
  private $db;

  public function __construct() {
    $this->db = new PDO('mysql:host=localhost;dbname=ajax','root', 'paris');
  }

  /**
   * @return Student array
   */
  function list() {
    $students = [];

    $query = $this->db->prepare('SELECT * FROM student');
    $result = $query->execute();
    $students_sql = $query->fetchAll(PDO::FETCH_OBJ);

    // transformation des objets génériques en Student
    foreach($students_sql as $s) {
      $student = new Student($s->firstname, $s->lastname);
      $students[] = $student;
    }

    return $students;
  }

  function getById($id) {}
  function getByLastname($id) {}
  function update($id, $data) {}
  function deleteAll() {}

}





//

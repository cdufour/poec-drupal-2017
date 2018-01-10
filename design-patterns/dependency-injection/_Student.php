<?php

class Student {
  private $lastname;
  private $firstname;

  public function __construct($first, $last) {
    // hydratation
    $this->firstname = ucfirst($first);
    $this->lastname = ucfirst($last);
  }

  public function getLastname() {
    return $this->lastname;
  }

  public function setLastname($lastname) {
    $this->lastname = $lastname;
    return $this;
  }

  public function getFirstname() {
    return $this->firstname;
  }

  public function setFirstname($firstname) {
    $this->firstname = $firstname;
    return $this;
  }

  public function getFullname() {
    return $this->firstname . ' ' . $this->lastname;
  }

  public function list() {
    // récupérer les données SQL
    // fetcher les données
    // les convertir en objets de type student

    // Mauvaise conception
    // la classe Student n'a pas dialoguer avec SQL
    // ni a renvoyer une liste
    // Bonne pratique: créer une classe spécifique
    // => StudentManager
    $students = ['A','B','C']; // tableau d'étudiants
    return $students;
  }
}


?>

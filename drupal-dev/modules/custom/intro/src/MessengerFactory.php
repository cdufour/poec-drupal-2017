<?php

namespace Drupal\intro;

class MessengerFactory {

  private $message;

  public function __construct() {
    $this->message = "Message de MessengerFactory";
  }

  public function getMessage() {
    return $this->message;
  }

}

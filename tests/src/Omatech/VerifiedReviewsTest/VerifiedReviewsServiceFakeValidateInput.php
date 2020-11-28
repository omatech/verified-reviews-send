<?php

namespace Omatech\VerifiedReviewsTest;
use Omatech\VerifiedReviews\VerifiedReviewsServiceInterface;

class VerifiedReviewsServiceFakeValidateInput implements VerifiedReviewsServiceInterface
{

  public $url;
  public $website_id;
  public $secret_key;
  public $full_url;
  public $last_record_sent;
  public $last_debug;

  function __construct($url, $website_id, $secret_key)
  {
    $this->url=$url;
    $this->website_id=$website_id;
    $this->secret_key=$secret_key;
  }

  function send($order_ref, $firstname, $lastname, $email, $order_date, $delay='0', $really_send=true)
  {
      if (empty(trim($order_ref)) || empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($email)) || empty(trim($order_date))) {
          $this->last_debug="Some input missing (order_ref, firsname, lastname, email, order_date)";
          return false;
      }
      $this->last_debug='This class should not be tested like that!';
      return true;
  }
}

<?php

namespace Omatech\VerifiedReviews;

class VerifiedReviewsService implements VerifiedReviewsServiceInterface
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

  function send($order_ref, $firstname, $lastname, $email, $order_date, $delay='0')
  {

    if (empty(trim($order_ref)) || empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($email)) || empty(trim($order_date))) {
      $this->last_debug="Some input missing (order_ref, firsname, lastname, email, order_date)";
      return false;
    }

    $query='pushCommandeSHA1';
    $action='/index.php?action=act_api_notification_sha1&type=json2';
    $this->full_url=$this->url.$action;

    $record=[
      'query'=>$query
      , 'order_ref'=>$order_ref
      ,'firstname'=>$firstname
      ,'lastname'=>$lastname
      ,'email'=>$email
      ,'order_date'=>$order_date
      , 'delay' => $delay
      ,'sign'=>sha1($query.$order_ref.$email.$lastname.$firstname.$order_date.$delay.$this->secret_key)
    ];

    $this->last_record_sent=$record;

    $encryptedNotification=http_build_query(
      array(
          'idWebsite' => $this->website_id,
          'message' => json_encode($record)
      )
    );

    $postNotification = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $encryptedNotification
        )
    );

    $contextNotification = stream_context_create($postNotification);

    $result = file_get_contents($this->url.'?action=act_api_notification_sha1&type=json2', false, $contextNotification);
    
    $resultArray = json_decode($result,true);

    $status=$resultArray['return'];
    $this->last_status=$status;
    $this->last_debug=$resultArray['debug'];
    if ($status==1)
    {
      return true;
    }
    else
    {

      return false;
    }
  }
}

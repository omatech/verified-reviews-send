<?php

namespace Omatech\VerifiedReviewsTest;
use Omatech\VerifiedReviews\VerifiedReviewsServiceInterface;

class VerifiedReviewsServiceFakeAllwaysOK implements VerifiedReviewsServiceInterface
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

    if ($really_send)
    {
      $debug='In theory we are sending the record, but this is a fake class';
    }
    else
    {
      $debug='We don\'t have to send the record, but this is a fake class';
    }

    $status=1;
    $this->last_status=$status;
    $this->last_debug=$debug;
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

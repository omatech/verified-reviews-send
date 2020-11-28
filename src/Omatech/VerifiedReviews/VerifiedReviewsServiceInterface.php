<?php

namespace Omatech\VerifiedReviews;

interface VerifiedReviewsServiceInterface {

  function send($order_ref, $firstname, $lastname, $email, $order_date, $delay='0', $really_send=true);
}
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Omatech\VerifiedReviewsTest\VerifiedReviewsServiceFakeAllwaysOK;
use Omatech\VerifiedReviewsTest\VerifiedReviewsServiceFakeValidateInput;

use function PHPUnit\Framework\assertEquals;

class SendOpinionTest extends TestCase
{
    public function testDummy()
    {
      $this->assertNotFalse(true);
    }

    public function testVerifiedReviewsServiceObject()
    {
      $verifiedReviewService = new VerifiedReviewsServiceFakeAllwaysOK(
        $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
        , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
        , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);
      $this->assertNotFalse($verifiedReviewService);
      $this->assertEquals($_ENV['VERIFIED_REVIEWS_SERVICE_URL'], $verifiedReviewService->url);
      $this->assertEquals($_ENV['VERIFIED_REVIEWS_WEBSITE_ID'], $verifiedReviewService->website_id);
      $this->assertEquals($_ENV['VERIFIED_REVIEWS_SECRET_KEY'], $verifiedReviewService->secret_key);
    }

    public function testSendVerifiedReviewMissingParams()
    {
      $verifiedReviewService = new VerifiedReviewsServiceFakeValidateInput(
        $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
        , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
        , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);

      $ret=$verifiedReviewService->send(
        ' '
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      );
      $this->assertFalse($ret);
      $this->assertEquals($verifiedReviewService->last_debug, 'Some input missing (order_ref, firsname, lastname, email, order_date)');

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , ''
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      );
      $this->assertFalse($ret);
      $this->assertEquals($verifiedReviewService->last_debug, 'Some input missing (order_ref, firsname, lastname, email, order_date)');

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , ' '
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      );
      $this->assertFalse($ret);
      $this->assertEquals($verifiedReviewService->last_debug, 'Some input missing (order_ref, firsname, lastname, email, order_date)');

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , null
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      );
      $this->assertFalse($ret);
      $this->assertEquals($verifiedReviewService->last_debug, 'Some input missing (order_ref, firsname, lastname, email, order_date)');

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , 0
      );
      $this->assertFalse($ret);
      $this->assertEquals($verifiedReviewService->last_debug, 'Some input missing (order_ref, firsname, lastname, email, order_date)');
    }

    public function testSendVerifiedReviewOK()
    {
      $verifiedReviewService = new VerifiedReviewsServiceFakeAllwaysOK(
        $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
        , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
        , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      );
      $this->assertNotFalse($ret);
      $this->assertJson(json_encode($verifiedReviewService->last_record_sent), '{
        "query": "pushCommandeSHA1",
        "order_ref": "000001",
        "firstname": "Agusti",
        "lastname": "Pons Zapater",
        "email": "apons@omatech.com",
        "order_date": "2020-11-22 09:01:02",
        "delay": "0",
        "sign": "14a02c7832b85e368024a4beb43ec398595abd20"
    }');
    
      assertEquals($verifiedReviewService->last_debug, 'In theory we are sending the record, but this is a fake class');
    }


    public function testSendVerifiedReviewOKWithoutSending()
    {
      $verifiedReviewService = new VerifiedReviewsServiceFakeAllwaysOK(
        $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
        , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
        , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);

      $ret=$verifiedReviewService->send(
        $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
      , $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
      , $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
      , $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
      , 1
      , false
      );
      $this->assertNotFalse($ret);
      $this->assertJson(json_encode($verifiedReviewService->last_record_sent), '{
        "query": "pushCommandeSHA1",
        "order_ref": "000001",
        "firstname": "Agusti",
        "lastname": "Pons Zapater",
        "email": "apons@omatech.com",
        "order_date": "2020-11-22 09:01:02",
        "delay": "1",
        "sign": "14a02c7832b85e368024a4beb43ec398595abd20"
    }');
    
      assertEquals($verifiedReviewService->last_debug, 'We don\'t have to send the record, but this is a fake class');
    }

}

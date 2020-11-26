# Verified Reviews Send

[![Latest Version on Packagist](https://img.shields.io/packagist/v/omatech/verified-reviews-send.svg?style=flat-square)](https://packagist.org/packages/omatech/verified-reviews-send)
[![Total Downloads](https://img.shields.io/packagist/dt/omatech/verified-reviews-send.svg?style=flat-square)](https://packagist.org/packages/omatech/verified-reviews-send)


The aim of this package is to ease the sending of purchases made by your customers to verified opinions.

Simply setup the connection and start sending requests to verified opinions.

## Installation

You can install the package via composer:

```bash
composer require omatech/verified-reviews-send
```

Environment configuration:

```env
Recomended:
VERIFIED_REVIEWS_SERVICE_URL=https://www.opiniones-verificadas.com
VERIFIED_REVIEWS_WEBSITE_ID=xxxx
VERIFIED_REVIEWS_SECRET_KEY=xxxx
```

## Usage

``` php
// Init the connection with verified reviews
$verifiedReviewService = new VerifiedReviewsService(
  $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
  , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
  , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);

$delay=0; // the delay in days you want to wait before verified opinions send the mail to the user
foreach ($orders as $order) 
{
  // Send a new purchase
  $ret=$verifiedReviewService->send(
    $order->order_ref // your order reference number
  , $order->firstname
  , $order->lastname
  , $order->email
  , $order->orderdate //yyyy-mm-dd hh24:mi:ss
  , $delay // optional parameter, default 0 
  );
}

```


### Testing

``` bash
composer test
```

Note: Change the test execution to vendor/bin/phpunit if you are not in Windows

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email apons@omatech.com instead of using the issue tracker.

## Credits

- [Agusti Pons](https://github.com/aponscat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
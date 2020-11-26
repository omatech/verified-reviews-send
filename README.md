# Verified Reviews Send

[![Latest Version on Packagist](https://img.shields.io/packagist/v/omatech/verified-reviews-send.svg?style=flat-square)](https://packagist.org/packages/omatech/verified-reviews-send)
[![Total Downloads](https://img.shields.io/packagist/dt/omatech/verified-reviews-send.svg?style=flat-square)](https://packagist.org/packages/omatech/verified-reviews-send)

Use of Verified Reviews Send:

``` php
// Init the connection with verified reviews
$verifiedReviewService = new VerifiedReviewsService(
  $_ENV['VERIFIED_REVIEWS_SERVICE_URL']
  , $_ENV['VERIFIED_REVIEWS_WEBSITE_ID']
  , $_ENV['VERIFIED_REVIEWS_SECRET_KEY']);

// Send a new purchase
$ret=$verifiedReviewService->send(
  $_ENV['VERIFIED_REVIEWS_TEST_ORDERREF']
, $_ENV['VERIFIED_REVIEWS_TEST_FIRSTNAME']
, $_ENV['VERIFIED_REVIEWS_TEST_LAST_NAME']
, $_ENV['VERIFIED_REVIEWS_TEST_EMAIL']
, $_ENV['VERIFIED_REVIEWS_TEST_ORDER_DATE']
);

```


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
VERIFIED_REVIEWS_TEST_EMAILxxx
VERIFIED_REVIEWS_TEST_FIRSTNAME=firstname
VERIFIED_REVIEWS_TEST_LAST_NAME=lastname
VERIFIED_REVIEWS_TEST_ORDERREF=000001
VERIFIED_REVIEWS_TEST_ORDER_DATE=2020-11-22 09:01:02
```

## Usage

XXX:

``` php


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
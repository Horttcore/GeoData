# Geodata

## Installation

`composer require ralfhortt/address`

## Example

```php
<?php
require 'vendor/autoload.php';

use RalfHortt\GeoData\Address;

$address = new Address('Mainzer Str. 37, 66111 Saarbrücken, Deutschland');
?>
<dl>
<dt>Straße</dt>
<dd><?= $address->getStreet() ?></dd>
<dt>Hausnummer</dt>
<dd><?= $address->getStreetNumber() ?></dd>
<dt>PLZ</dt>
<dd><?= $address->getPostCode() ?></dd>
<dt>Stadt</dt>
<dd><?= $address->getCity() ?></dd>
<dt>Land</dt>
<dd><?= $address->getCountry() ?></dd>
<dt>Latitude</dt>
<dd><?= $address->getLatitude() ?></dd>
<dt>Longitude</dt>
<dd><?= $address->getLongitude() ?></dd>
</dl>
```

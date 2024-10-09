<?php

use RalfHortt\GeoData\Address;

test('Check if class can be autoloaded', function () {
    expect(class_exists(Address::class))->toBeTrue();
});

test('Check if Address has a response', function () {
    $a = new Address('Mainzer Strasse 37, 66111 Saarbrücken');
    expect($a->getCountry())->toBe('Deutschland');
    expect($a->getCity())->toBe('Saarbrücken');
    expect($a->getStreet())->toBe('Mainzer Straße');
    expect($a->getStreetNumber())->toBe('37');
    expect($a->getPostCode())->toBe('66111');
    expect($a->getLatitude())->toBe(49.2308104);
    expect($a->getLongitude())->toBe(7.0022087);
});

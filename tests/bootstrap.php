<?php
require '../vendor/autoload.php';

Tester\Environment::setup();

date_default_timezone_set('Europe/Prague');

function test(string $description, Closure $fn): void {
    echo $description, "\n";
    $fn();
}


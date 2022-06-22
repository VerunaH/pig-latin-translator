<?php

use App\Model\TranslationManager;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

/** @var TranslationManager @inject * */
$translator = new TranslationManager();

test('all types sentences', function () use ($translator) {
    Assert::same('eway areyay eethray igspay', $translator->translate('we are three pigs'));
    Assert::same('inkpay igpay ellssmay awfullyyay', $translator->translate('pink pig smells awfully'));
});

test('special chars words should be omited', function () use ($translator) {
    Assert::same('3 igspay aidpay 20$ orfay eakstay', $translator->translate('3 pigs paid 20$ for steak'));
    Assert::same('3  p-i-g-s pa.id 20$ orfay eakstay', $translator->translate('3  p-i-g-s pa.id 20$ for steak'));
});

test('empty sentence', function () use ($translator) {
    Assert::same('', $translator->translate(''));
});
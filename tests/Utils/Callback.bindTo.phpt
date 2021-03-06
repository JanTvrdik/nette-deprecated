<?php

/**
 * Test: Nette\Callback tests.
 */

use Nette\Callback;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


class Test
{
	public $var;

	function set($val)
	{
		$this->var = $val;
	}
}


test(function () {
	$test = new Test;
	$cb = Callback::create('Test::set');
	$cb2 = $cb->bindTo($test);

	Assert::notSame($cb, $cb2);

	$cb2(2);
	Assert::same(2, $test->var);
});


test(function () {
	Assert::exception(function () {
		Callback::create('strlen')->bindTo(new stdClass);
	}, 'Nette\InvalidStateException', "Callback 'strlen' have not any bound object.");

	Assert::exception(function () {
		Callback::create('Test::set')->bindTo(1);
	}, 'InvalidArgumentException', 'Invalid callback.');
});

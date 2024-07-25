<?php

declare(strict_types=1);

namespace Rinvex\Country\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rinvex\Country\CurrencyLoader;
use PHPUnit\Framework\Attributes\Test;

class CurrencyLoaderTest extends TestCase
{
    /** @var array */
    protected static $methods;

    #[Test]
    public function it_returns_courrencies_longlist(): void
    {
        $this->assertEquals(165, count(CurrencyLoader::currencies(true)));
        $this->assertArrayHasKey('EGP', CurrencyLoader::currencies());
        $this->assertIsArray(CurrencyLoader::currencies(true)['EGP']);
        $this->assertEquals('EGP', CurrencyLoader::currencies(true)['EGP']['iso_4217_code']);
        $this->assertEquals('818', CurrencyLoader::currencies(true)['EGP']['iso_4217_numeric']);
        $this->assertEquals('Egyptian Pound', CurrencyLoader::currencies(true)['EGP']['iso_4217_name']);
        $this->assertEquals('2', CurrencyLoader::currencies(true)['EGP']['iso_4217_minor_unit']);
    }

    #[Test]
    public function it_returns_courrencies_shortlist(): void
    {
        $this->assertEquals(165, count(CurrencyLoader::currencies()));
        $this->assertArrayHasKey('EGP', CurrencyLoader::currencies());
        $this->assertIsString(CurrencyLoader::currencies()['EGP']);
        $this->assertEquals('EGP', CurrencyLoader::currencies()['EGP']);
    }
}

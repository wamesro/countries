<?php

declare(strict_types=1);

namespace Rinvex\Country\Tests\Unit;

use Exception;
use Rinvex\Country\Country;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CountryTest extends TestCase
{
    /** @var array */
    protected $shortAttributes;

    /** @var array */
    protected $longAttributes;

    /** @var Country */
    protected $shortCountry;

    /** @var Country */
    protected $longCountry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shortAttributes = [
            'name' => 'Egypt',
            'official_name' => 'Arab Republic of Egypt',
            'native_name' => 'مصر',
            'native_official_name' => 'جمهورية مصر العربية',
            'iso_3166_1_alpha2' => 'EG',
            'iso_3166_1_alpha3' => 'EGY',
            'calling_code' => ['20'],
            'emoji' => '🇪🇬',
        ];

        $this->longAttributes = [
            'name' => [
                'common' => 'Egypt',
                'official' => 'Arab Republic of Egypt',
                'native' => [
                    'ara' => [
                        'common' => 'مصر',
                        'official' => 'جمهورية مصر العربية',
                    ],
                ],
            ],
            'demonym' => 'Egyptian',
            'capital' => 'Cairo',
            'iso_3166_1_alpha2' => 'EG',
            'iso_3166_1_alpha3' => 'EGY',
            'iso_3166_1_numeric' => '818',
            'currency' => [
                'EGP' => [
                    'iso_4217_code' => 'EGP',
                    'iso_4217_numeric' => 818,
                    'iso_4217_name' => 'Egyptian Pound',
                    'iso_4217_minor_unit' => 2,
                ],
            ],
            'tld' => [
                '.eg',
                '.مصر',
            ],
            'alt_spellings' => [
                'EG',
                'Arab Republic of Egypt',
            ],
            'languages' => [
                'ara' => 'Arabic',
            ],
            'geo' => [
                'continent' => [
                    'AF' => 'Africa',
                ],
                'postal_code' => true,
                'latitude' => '27 00 N',
                'latitude_desc' => '26.756103515625',
                'longitude' => '30 00 E',
                'longitude_desc' => '29.86229705810547',
                'max_latitude' => '31.916667',
                'max_longitude' => '36.333333',
                'min_latitude' => '20.383333',
                'min_longitude' => '24.7',
                'area' => 1002450,
                'region' => 'Africa',
                'subregion' => 'Northern Africa',
                'world_region' => 'EMEA',
                'region_code' => '002',
                'subregion_code' => '015',
                'landlocked' => false,
                'borders' => [
                    'ISR',
                    'LBY',
                    'SDN',
                ],
                'independent' => 'Yes',
            ],
            'dialling' => [
                'calling_code' => [
                    '20',
                ],
                'national_prefix' => '0',
                'national_number_lengths' => [
                    9,
                ],
                'national_destination_code_lengths' => [
                    2,
                ],
                'international_prefix' => '00',
            ],
            'extra' => [
                'geonameid' => 357994,
                'edgar' => 'H2',
                'itu' => 'EGY',
                'marc' => 'ua',
                'wmo' => 'EG',
                'ds' => 'ET',
                'fifa' => 'EGY',
                'fips' => 'EG',
                'gaul' => 40765,
                'ioc' => 'EGY',
                'cowc' => 'EGY',
                'cown' => 651,
                'fao' => 59,
                'imf' => 469,
                'ar5' => 'MAF',
                'address_format' => '{{recipient}}\n{{street}}\n{{postalcode}} {{city}}\n{{country}}',
                'eu_member' => null,
                'data_protection' => 'Other',
                'vat_rates' => null,
                'emoji' => '🇪🇬',
            ],
            'divisions' => [
                'ALX' => [
                    'name' => 'Al Iskandariyah',
                    'alt_names' => [
                        'El Iskandariya',
                        'al-Iskandariyah',
                        'al-Iskandarīyah',
                        'Alexandria',
                        'Alexandrie',
                        'Alexandria',
                    ],
                    'geo' => [
                        'latitude' => 31.2000924,
                        'longitude' => 29.9187387,
                        'min_latitude' => 31.1173177,
                        'min_longitude' => 29.8233701,
                        'max_latitude' => 31.330904,
                        'max_longitude' => 30.0864016,
                    ],
                ],
            ],
        ];

        $this->shortCountry = new Country($this->shortAttributes);
        $this->longCountry = new Country($this->longAttributes);
    }

    #[Test]
    public function it_throws_an_exception_when_missing_mandatory_attributes(): void
    {
        $this->expectException(Exception::class);

        new Country([]);
    }

    #[Test]
    public function it_sets_attributes_once_instantiated(): void
    {
        $this->assertEquals($this->shortAttributes['name'], $this->shortCountry->getName());
        $this->assertEquals($this->shortAttributes['official_name'], $this->shortCountry->getOfficialName());
        $this->assertEquals($this->shortAttributes['native_name'], $this->shortCountry->getNativeName());
        $this->assertEquals($this->shortAttributes['native_official_name'], $this->shortCountry->getNativeOfficialName());
        $this->assertEquals('EG', $this->shortCountry->getIsoAlpha2());
        $this->assertEquals('EGY', $this->shortCountry->getIsoAlpha3());
    }

    #[Test]
    public function it_gets_attributes(): void
    {
        $this->assertEquals($this->shortAttributes, $this->shortCountry->getAttributes());
    }

    #[Test]
    public function it_sets_attributes(): void
    {
        $this->shortCountry->setAttributes(['capital' => 'Cairo']);

        $this->assertEquals('Cairo', $this->shortCountry->getCapital());
    }

    #[Test]
    public function it_gets_dotted_attribute(): void
    {
        $this->assertEquals($this->shortAttributes['calling_code'], $this->shortCountry->get('calling_code'));
        $this->assertEquals($this->longAttributes['name']['native']['ara']['common'], $this->longCountry->get('name.native.ara.common'));
    }

    #[Test]
    public function it_gets_default_when_missing_value(): void
    {
        $this->assertEquals('default', $this->shortCountry->get('unknown', 'default'));
    }

    #[Test]
    public function it_gets_all_attributes_when_missing_key(): void
    {
        $this->assertEquals($this->shortAttributes, $this->shortCountry->get(null));
    }

    #[Test]
    public function it_sets_attribute(): void
    {
        $this->shortCountry->set('capital', 'Cairo');

        $this->assertEquals('Cairo', $this->shortCountry->getCapital());
    }

    #[Test]
    public function its_fluently_chainable_when_sets_attributes(): void
    {
        $this->assertEquals($this->shortCountry, $this->shortCountry->setAttributes([]));
    }

    #[Test]
    public function it_returns_name_from_longlist(): void
    {
        $this->assertEquals($this->longAttributes['name']['common'], $this->longCountry->getName());
    }

    #[Test]
    public function it_returns_name_from_shortlist(): void
    {
        $this->assertEquals($this->shortAttributes['name'], $this->shortCountry->getName());
    }

    #[Test]
    public function it_returns_null_when_missing_name(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getName());
    }

    #[Test]
    public function it_returns_official_name_from_longlist(): void
    {
        $this->assertEquals($this->longAttributes['name']['official'], $this->longCountry->getOfficialName());
    }

    #[Test]
    public function it_returns_official_name_from_shortlist(): void
    {
        $this->assertEquals($this->shortAttributes['official_name'], $this->shortCountry->getOfficialName());
    }

    #[Test]
    public function it_returns_null_when_missing_official_name(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getOfficialName());
    }

    #[Test]
    public function it_returns_native_name_from_longlist(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara']['common'], $this->longCountry->getNativeName());
    }

    #[Test]
    public function it_returns_native_name_from_shortlist(): void
    {
        $this->assertEquals($this->shortAttributes['native_name'], $this->shortCountry->getNativeName());
    }

    #[Test]
    public function it_returns_null_when_missing_native_name(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getNativeName());
    }

    #[Test]
    public function it_returns_native_official_name_from_longlist(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara']['official'], $this->longCountry->getNativeOfficialName());
    }

    #[Test]
    public function it_returns_native_official_name_from_shortlist(): void
    {
        $this->assertEquals($this->shortAttributes['native_official_name'], $this->shortCountry->getNativeOfficialName());
    }

    #[Test]
    public function it_returns_null_when_missing_native_official_name(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getNativeOfficialName());
    }

    #[Test]
    public function it_returns_array_of_native_names_from_longlist(): void
    {
        $this->assertNotEmpty($this->longCountry->getNativeNames());
        $this->assertEquals(current($this->longAttributes['name']['native']), current($this->longCountry->getNativeNames()));
    }

    #[Test]
    public function it_returns_null_when_missing_native_names(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getNativeNames());
    }

    #[Test]
    public function it_returns_demonym(): void
    {
        $this->assertEquals($this->longAttributes['demonym'], $this->longCountry->getDemonym());
    }

    #[Test]
    public function it_returns_null_when_missing_demonym(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getDemonym());
    }

    #[Test]
    public function it_returns_capital(): void
    {
        $this->assertEquals($this->longAttributes['capital'], $this->longCountry->getCapital());
    }

    #[Test]
    public function it_returns_null_when_missing_capital(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCapital());
    }

    #[Test]
    public function it_returns_isoalpha2(): void
    {
        $this->assertEquals($this->longAttributes['iso_3166_1_alpha2'], $this->longCountry->getIsoAlpha2());
    }

    #[Test]
    public function it_returns_null_when_missing_isoalpha2(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getIsoAlpha2());
    }

    #[Test]
    public function it_returns_isoalpha3(): void
    {
        $this->assertEquals($this->longAttributes['iso_3166_1_alpha3'], $this->longCountry->getIsoAlpha3());
    }

    #[Test]
    public function it_returns_null_when_missing_isoalpha3(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getIsoAlpha3());
    }

    #[Test]
    public function it_returns_isonumeric(): void
    {
        $this->assertEquals($this->longAttributes['iso_3166_1_numeric'], $this->longCountry->getIsoNumeric());
    }

    #[Test]
    public function it_returns_null_when_missing_isonumeric(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getIsoNumeric());
    }

    #[Test]
    public function it_returns_currency(): void
    {
        $this->assertEquals($this->longAttributes['currency']['EGP'], $this->longCountry->getCurrency());
    }

    #[Test]
    public function it_returns_first_currency_when_missing_requested_currency(): void
    {
        $this->assertEquals($this->longAttributes['currency']['EGP'], $this->longCountry->getCurrency('USD'));
    }

    #[Test]
    public function it_returns_null_when_missing_currency(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCurrency());
    }

    #[Test]
    public function it_returns_currencies(): void
    {
        $this->assertEquals($this->longAttributes['currency'], $this->longCountry->getCurrencies());
    }

    #[Test]
    public function it_returns_null_when_missing_currencies(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCurrencies());
    }

    #[Test]
    public function it_returns_tld(): void
    {
        $this->assertEquals(current($this->longAttributes['tld']), $this->longCountry->getTld());
    }

    #[Test]
    public function it_returns_null_when_missing_tld(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getTld());
    }

    #[Test]
    public function it_returns_tlds(): void
    {
        $this->assertEquals($this->longAttributes['tld'], $this->longCountry->getTlds());
    }

    #[Test]
    public function it_returns_null_when_missing_tlds(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getTlds());
    }

    #[Test]
    public function it_returns_altspellings(): void
    {
        $this->assertEquals($this->longAttributes['alt_spellings'], $this->longCountry->getAltSpellings());
    }

    #[Test]
    public function it_returns_null_when_missing_altspellings(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getAltSpellings());
    }

    #[Test]
    public function it_returns_language(): void
    {
        $this->assertEquals($this->longAttributes['languages']['ara'], $this->longCountry->getLanguage());
    }

    #[Test]
    public function it_returns_first_currency_when_missing_requested_language(): void
    {
        $this->assertEquals($this->longAttributes['languages']['ara'], $this->longCountry->getLanguage('eng'));
    }

    #[Test]
    public function it_returns_null_when_missing_language(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLanguage());
    }

    #[Test]
    public function it_returns_languages(): void
    {
        $this->assertEquals($this->longAttributes['languages'], $this->longCountry->getLanguages());
    }

    #[Test]
    public function it_returns_null_when_missing_languages(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLanguages());
    }

    #[Test]
    public function it_returns_translation(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara'], $this->longCountry->getTranslation());
    }

    #[Test]
    public function it_returns_first_translation_when_missing_requested_translation(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara'], $this->longCountry->getTranslation('ara'));
    }

    #[Test]
    public function it_returns_translations(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara'], $this->longCountry->getTranslations()['ara']);
    }

    #[Test]
    public function it_returns_first_translation_when_missing_requested_translations(): void
    {
        $this->assertEquals($this->longAttributes['name']['native']['ara'], $this->longCountry->getTranslation('ara'));
    }

    #[Test]
    public function it_returns_geodata(): void
    {
        $this->assertEquals($this->longAttributes['geo'], $this->longCountry->getGeodata());
    }

    #[Test]
    public function it_returns_null_when_missing_geodata(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getGeodata());
    }

    #[Test]
    public function it_returns_continent(): void
    {
        $this->assertEquals(current($this->longAttributes['geo']['continent']), $this->longCountry->getContinent());
    }

    #[Test]
    public function it_returns_null_when_missing_continent(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getContinent());
    }

    #[Test]
    public function it_returns_postal_code(): void
    {
        $this->assertEquals($this->longAttributes['geo']['postal_code'], $this->longCountry->usesPostalCode());
    }

    #[Test]
    public function it_returns_null_when_missing_postal_code(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->usesPostalCode());
    }

    #[Test]
    public function it_returns_latitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['latitude'], $this->longCountry->getLatitude());
    }

    #[Test]
    public function it_returns_null_when_missing_latitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLatitude());
    }

    #[Test]
    public function it_returns_latitude_desc(): void
    {
        $this->assertEquals($this->longAttributes['geo']['latitude_desc'], $this->longCountry->getLatitudeDesc());
    }

    #[Test]
    public function it_returns_null_when_missing_latitude_desc(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLatitudeDesc());
    }

    #[Test]
    public function it_returns_max_latitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['max_latitude'], $this->longCountry->getMaxLatitude());
    }

    #[Test]
    public function it_returns_null_when_missing_lmax_latitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getMaxLatitude());
    }

    #[Test]
    public function it_returns_longitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['longitude'], $this->longCountry->getLongitude());
    }

    #[Test]
    public function it_returns_null_when_missing_longitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLongitude());
    }

    #[Test]
    public function it_returns_longitude_desc(): void
    {
        $this->assertEquals($this->longAttributes['geo']['longitude_desc'], $this->longCountry->getLongitudeDesc());
    }

    #[Test]
    public function it_returns_null_when_missing_longitude_desc(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getLongitudeDesc());
    }

    #[Test]
    public function it_returns_max_longitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['max_longitude'], $this->longCountry->getMaxLongitude());
    }

    #[Test]
    public function it_returns_null_when_missing_max_longitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getMaxLongitude());
    }

    #[Test]
    public function it_returns_min_longitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['min_longitude'], $this->longCountry->getMinLongitude());
    }

    #[Test]
    public function it_returns_null_when_missing_min_longitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getMinLongitude());
    }

    #[Test]
    public function it_returns_min_latitude(): void
    {
        $this->assertEquals($this->longAttributes['geo']['min_latitude'], $this->longCountry->getMinLatitude());
    }

    #[Test]
    public function it_returns_null_when_missing_min_latitude(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getMinLatitude());
    }

    #[Test]
    public function it_returns_area(): void
    {
        $this->assertEquals($this->longAttributes['geo']['area'], $this->longCountry->getArea());
    }

    #[Test]
    public function it_returns_null_when_missing_area(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getArea());
    }

    #[Test]
    public function it_returns_region(): void
    {
        $this->assertEquals($this->longAttributes['geo']['region'], $this->longCountry->getRegion());
    }

    #[Test]
    public function it_returns_null_when_missing_region(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getRegion());
    }

    #[Test]
    public function it_returns_subregion(): void
    {
        $this->assertEquals($this->longAttributes['geo']['subregion'], $this->longCountry->getSubregion());
    }

    #[Test]
    public function it_returns_null_when_missing_subregion(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getSubregion());
    }

    #[Test]
    public function it_returns_world_region(): void
    {
        $this->assertEquals($this->longAttributes['geo']['world_region'], $this->longCountry->getWorldRegion());
    }

    #[Test]
    public function it_returns_null_when_missing_world_region(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getWorldRegion());
    }

    #[Test]
    public function it_returns_region_code(): void
    {
        $this->assertEquals($this->longAttributes['geo']['region_code'], $this->longCountry->getRegionCode());
    }

    #[Test]
    public function it_returns_null_when_missing_region_code(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getRegionCode());
    }

    #[Test]
    public function it_returns_subregion_code(): void
    {
        $this->assertEquals($this->longAttributes['geo']['subregion_code'], $this->longCountry->getSubregionCode());
    }

    #[Test]
    public function it_returns_null_when_missing_subregion_code(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getSubregionCode());
    }

    #[Test]
    public function it_returns_landlocked_status(): void
    {
        $this->assertEquals($this->longAttributes['geo']['landlocked'], $this->longCountry->isLandlocked());
    }

    #[Test]
    public function it_returns_null_when_missing_landlocked_status(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->isLandlocked());
    }

    #[Test]
    public function it_returns_borders(): void
    {
        $this->assertEquals($this->longAttributes['geo']['borders'], $this->longCountry->getBorders());
    }

    #[Test]
    public function it_returns_null_when_missing_borders(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getBorders());
    }

    #[Test]
    public function it_returns_independent_status(): void
    {
        $this->assertEquals($this->longAttributes['geo']['independent'], $this->longCountry->isIndependent());
    }

    #[Test]
    public function it_returns_null_when_missing_independent_status(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->isIndependent());
    }

    #[Test]
    public function it_returns_calling_code_from_longlist(): void
    {
        $this->assertEquals(current($this->longAttributes['dialling']['calling_code']), $this->longCountry->getCallingCode());
    }

    #[Test]
    public function it_returns_calling_code_from_shortlist(): void
    {
        $this->assertEquals(current($this->shortAttributes['calling_code']), $this->shortCountry->getCallingCode());
    }

    #[Test]
    public function it_returns_null_when_missing_calling_code(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCallingCode());
    }

    #[Test]
    public function it_returns_calling_codes(): void
    {
        $this->assertEquals($this->longAttributes['dialling']['calling_code'], $this->longCountry->getCallingCodes());
    }

    #[Test]
    public function it_returns_null_when_missing_calling_codes(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCallingCodes());
    }

    #[Test]
    public function it_returns_national_prefix(): void
    {
        $this->assertEquals($this->longAttributes['dialling']['national_prefix'], $this->longCountry->getNationalPrefix());
    }

    #[Test]
    public function it_returns_null_when_missing_national_prefix(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getNationalPrefix());
    }

    #[Test]
    public function it_returns_national_number_length(): void
    {
        $this->assertEquals(current($this->longAttributes['dialling']['national_number_lengths']), $this->longCountry->getNationalNumberLength());
    }

    #[Test]
    public function it_returns_null_when_missing_national_number_length(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getNationalNumberLength());
    }

    #[Test]
    public function it_returns_national_number_lengths(): void
    {
        $this->assertEquals($this->longAttributes['dialling']['national_number_lengths'], $this->longCountry->getNationalNumberLengths());
    }

    #[Test]
    public function it_returns_null_when_missing_national_number_lengths(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getNationalNumberLengths());
    }

    #[Test]
    public function it_returns_national_destination_code_length(): void
    {
        $this->assertEquals(current($this->longAttributes['dialling']['national_destination_code_lengths']), $this->longCountry->getNationalDestinationCodeLength());
    }

    #[Test]
    public function it_returns_null_when_missing_national_destination_code_length(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getNationalDestinationCodeLength());
    }

    #[Test]
    public function it_returns_national_destination_code_lengths(): void
    {
        $this->assertEquals($this->longAttributes['dialling']['national_destination_code_lengths'], $this->longCountry->getNationalDestinationCodeLengths());
    }

    #[Test]
    public function it_returns_null_when_missing_national_destination_code_lengths(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getNationalDestinationCodeLengths());
    }

    #[Test]
    public function it_returns_international_prefix(): void
    {
        $this->assertEquals($this->longAttributes['dialling']['international_prefix'], $this->longCountry->getInternationalPrefix());
    }

    #[Test]
    public function it_returns_null_when_missing_international_prefix(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getInternationalPrefix());
    }

    #[Test]
    public function it_returns_extra(): void
    {
        $this->assertEquals($this->longAttributes['extra'], $this->longCountry->getExtra());
    }

    #[Test]
    public function it_returns_null_when_missing_extra(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getExtra());
    }

    #[Test]
    public function it_returns_geonameid(): void
    {
        $this->assertEquals($this->longAttributes['extra']['geonameid'], $this->longCountry->getGeonameid());
    }

    #[Test]
    public function it_returns_null_when_missing_geonameid(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getGeonameid());
    }

    #[Test]
    public function it_returns_edgar(): void
    {
        $this->assertEquals($this->longAttributes['extra']['edgar'], $this->longCountry->getEdgar());
    }

    #[Test]
    public function it_returns_null_when_missing_edgar(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getEdgar());
    }

    #[Test]
    public function it_returns_itu(): void
    {
        $this->assertEquals($this->longAttributes['extra']['itu'], $this->longCountry->getItu());
    }

    #[Test]
    public function it_returns_null_when_missing_itu(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getItu());
    }

    #[Test]
    public function it_returns_marc(): void
    {
        $this->assertEquals($this->longAttributes['extra']['marc'], $this->longCountry->getMarc());
    }

    #[Test]
    public function it_returns_null_when_missing_marc(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getMarc());
    }

    #[Test]
    public function it_returns_wmo(): void
    {
        $this->assertEquals($this->longAttributes['extra']['wmo'], $this->longCountry->getWmo());
    }

    #[Test]
    public function it_returns_null_when_missing_wmo(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getWmo());
    }

    #[Test]
    public function it_returns_ds(): void
    {
        $this->assertEquals($this->longAttributes['extra']['ds'], $this->longCountry->getDs());
    }

    #[Test]
    public function it_returns_null_when_missing_ds(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getDs());
    }

    #[Test]
    public function it_returns_fifa(): void
    {
        $this->assertEquals($this->longAttributes['extra']['fifa'], $this->longCountry->getFifa());
    }

    #[Test]
    public function it_returns_null_when_missing_fifa(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getFifa());
    }

    #[Test]
    public function it_returns_fips(): void
    {
        $this->assertEquals($this->longAttributes['extra']['fips'], $this->longCountry->getFips());
    }

    #[Test]
    public function it_returns_null_when_missing_fips(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getFips());
    }

    #[Test]
    public function it_returns_gaul(): void
    {
        $this->assertEquals($this->longAttributes['extra']['gaul'], $this->longCountry->getGaul());
    }

    #[Test]
    public function it_returns_null_when_missing_gaul(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getGaul());
    }

    #[Test]
    public function it_returns_ioc(): void
    {
        $this->assertEquals($this->longAttributes['extra']['ioc'], $this->longCountry->getIoc());
    }

    #[Test]
    public function it_returns_null_when_missing_ioc(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getIoc());
    }

    #[Test]
    public function it_returns_cowc(): void
    {
        $this->assertEquals($this->longAttributes['extra']['cowc'], $this->longCountry->getCowc());
    }

    #[Test]
    public function it_returns_null_when_missing_cowc(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCowc());
    }

    #[Test]
    public function it_returns_cown(): void
    {
        $this->assertEquals($this->longAttributes['extra']['cown'], $this->longCountry->getCown());
    }

    #[Test]
    public function it_returns_null_when_missing_cown(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getCown());
    }

    #[Test]
    public function it_returns_fao(): void
    {
        $this->assertEquals($this->longAttributes['extra']['fao'], $this->longCountry->getFao());
    }

    #[Test]
    public function it_returns_null_when_missing_fao(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getFao());
    }

    #[Test]
    public function it_returns_imf(): void
    {
        $this->assertEquals($this->longAttributes['extra']['imf'], $this->longCountry->getImf());
    }

    #[Test]
    public function it_returns_null_when_missing_imf(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getImf());
    }

    #[Test]
    public function it_returns_ar5(): void
    {
        $this->assertEquals($this->longAttributes['extra']['ar5'], $this->longCountry->getAr5());
    }

    #[Test]
    public function it_returns_null_when_missing_ar5(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getAr5());
    }

    #[Test]
    public function it_returns_address_format(): void
    {
        $this->assertEquals($this->longAttributes['extra']['address_format'], $this->longCountry->getAddressFormat());
    }

    #[Test]
    public function it_returns_null_when_missing_address_format(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getAddressFormat());
    }

    #[Test]
    public function it_returns_whether_eu_member(): void
    {
        $this->assertEquals($this->longAttributes['extra']['eu_member'], $this->longCountry->isEuMember());
    }

    #[Test]
    public function it_returns_null_when_missing_eu_member_status(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->isEuMember());
    }

    #[Test]
    public function it_returns_whether_data_protection(): void
    {
        $this->assertEquals($this->longAttributes['extra']['data_protection'], $this->longCountry->getDataProtection());
    }

    #[Test]
    public function it_returns_null_when_missing_data_protection_status(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getDataProtection());
    }

    #[Test]
    public function it_returns_vat_rates(): void
    {
        $this->assertEquals($this->longAttributes['extra']['vat_rates'], $this->longCountry->getVatRates());
    }

    #[Test]
    public function it_returns_null_when_missing_vat_rates(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getVatRates());
    }

    #[Test]
    public function it_returns_emoji_from_longlist(): void
    {
        $this->assertEquals($this->longAttributes['extra']['emoji'], $this->longCountry->getEmoji());
    }

    #[Test]
    public function it_returns_emoji_from_shortlist(): void
    {
        $this->assertEquals($this->shortAttributes['emoji'], $this->shortCountry->getEmoji());
    }

    #[Test]
    public function it_returns_null_when_missing_emoji(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getEmoji());
    }

    #[Test]
    public function it_returns_geojson(): void
    {
        $file = __DIR__.'/../../resources/geodata/'.mb_strtolower((string) $this->longCountry->getIsoAlpha2()).'.json';

        $this->assertEquals(file_get_contents($file), $this->longCountry->getGeoJson());
    }

    #[Test]
    public function it_returns_null_when_missing_geojson(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getGeoJson());
    }

    #[Test]
    public function it_returns_flag(): void
    {
        $file = __DIR__.'/../../resources/flags/'.mb_strtolower((string) $this->longCountry->getIsoAlpha2()).'.svg';

        $this->assertEquals(file_get_contents($file), $this->longCountry->getFlag());
    }

    #[Test]
    public function it_returns_null_when_missing_flag(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getFlag());
    }

    #[Test]
    public function it_returns_divisions(): void
    {
        $file = __DIR__.'/../../resources/divisions/'.mb_strtolower((string) $this->longCountry->getIsoAlpha2()).'.json';

        $this->assertEquals(json_decode(file_get_contents($file), true), $this->longCountry->getDivisions());
    }

    #[Test]
    public function it_returns_null_when_missing_divisions(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getDivisions());
    }

    #[Test]
    public function it_returns_division(): void
    {
        $this->assertEquals($this->longAttributes['divisions']['ALX'], $this->longCountry->getDivision('ALX'));
    }

    #[Test]
    public function it_returns_null_when_missing_division(): void
    {
        $this->longCountry->setAttributes([]);

        $this->assertNull($this->longCountry->getDivisions());
    }

    #[Test]
    public function it_returns_timezones(): void
    {
        $this->assertEquals(['Africa/Cairo'], $this->shortCountry->getTimezones());
    }

    #[Test]
    public function it_returns_null_when_missing_timezones(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getTimezones());
    }

    #[Test]
    public function it_returns_locales(): void
    {
        $this->assertEquals(['ar_EG'], $this->shortCountry->getLocales());
    }

    #[Test]
    public function it_returns_null_when_missing_locales(): void
    {
        $this->shortCountry->setAttributes([]);

        $this->assertNull($this->shortCountry->getLocales());
    }
}

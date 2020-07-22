<?php
use js\tools\numbers2words\Speller;
use js\tools\numbers2words\twig\SpellerExtension;
use PHPUnit\Framework\TestCase;

class ImplicitDefaultsTest extends TestCase
{
    public function testNumber(): void
    {
        $extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);

        $this->assertSame('one hundred twenty three', $extension->spellNumber(123));
    }

    public function testCurrency(): void
    {
        $extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);

        $this->assertSame('one hundred twenty three euro and 45 cents', $extension->spellCurrency(123.45));
        $this->assertSame('one hundred twenty three euro and 0 cents', $extension->spellCurrency(123));
    }

    public function testCurrencyDecimalModifiers(): void
    {
        $extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);
        $extension->spellDecimal = true;
        $this->assertSame('one hundred twenty three euro and zero cents', $extension->spellCurrency(123));
        $extension->requireDecimal = false;
        $this->assertSame('one hundred twenty three euro', $extension->spellCurrency(123));
        $this->assertSame('one hundred twenty three euro and forty five cents', $extension->spellCurrency(123.45));
    }

    public function testCurrencyShort(): void
    {
        $extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);

        $this->assertSame('one hundred twenty three EUR 45/100', $extension->spellCurrencyShort(123.45));
        $this->assertSame('one hundred twenty three EUR 0/100', $extension->spellCurrencyShort(123));
    }

    public function testOverrideDefaults(): void
    {
        $extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);

        $this->assertSame('сто двадцать три', $extension->spellNumber(123, Speller::LANGUAGE_RUSSIAN));
        $this->assertSame('сто двадцать три евро и 0 центов', $extension->spellCurrency(123, Speller::LANGUAGE_RUSSIAN));
        $this->assertSame(
            'сто двадцать три рубля и сорок пять копеек',
            $extension->spellCurrency(123.45, Speller::LANGUAGE_RUSSIAN, Speller::CURRENCY_RUSSIAN_ROUBLE, false, true)
        );
    }
}

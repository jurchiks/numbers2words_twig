<?php
namespace js\tools\numbers2words\twig;

use js\tools\numbers2words\Speller;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SpellerExtension extends AbstractExtension
{
    private string $defaultLanguage;
    private string $defaultCurrency;
    /** If false, only output the decimal part if it is >0. */
    public bool $requireDecimal = true;
    /** If true, spell the decimal part same as the whole part; otherwise, just return the decimal part as a number. */
    public bool $spellDecimal = false;

    /**
     * @param string $defaultLanguage - the implicit language to use if none provided (see Speller::LANGUAGE_* constants)
     * @param string $defaultCurrency - the implicit currency to use if none provided (see Speller::CURRENCY_* constants)
     */
    public function __construct(string $defaultLanguage, string $defaultCurrency)
    {
        $this->defaultLanguage = $defaultLanguage;
        $this->defaultCurrency = $defaultCurrency;
    }

    /** @codeCoverageIgnore */
    public function getFunctions()
    {
        return [
            new TwigFunction('spellNumber', [$this, 'spellNumber']),
            new TwigFunction('spellCurrency', [$this, 'spellCurrency']),
            new TwigFunction('spellCurrencyShort', [$this, 'spellCurrencyShort']),
        ];
    }

    public function spellNumber($number, ?string $language = null): string
    {
        return Speller::spellNumber($number, $language ?? $this->defaultLanguage);
    }

    public function spellCurrency($amount, ?string $language = null, ?string $currency = null, ?bool $requireDecimal = null, ?bool $spellDecimal = null): string
    {
        return Speller::spellCurrency(
            $amount,
            $language ?? $this->defaultLanguage,
            $currency ?? $this->defaultCurrency,
            $requireDecimal ?? $this->requireDecimal,
            $spellDecimal ?? $this->spellDecimal
        );
    }

    public function spellCurrencyShort($amount, ?string $language = null, ?string $currency = null): string
    {
        return Speller::spellCurrencyShort(
            $amount,
            $language ?? $this->defaultLanguage,
            $currency ?? $this->defaultCurrency
        );
    }
}

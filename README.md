# numbers2words_twig
Twig extension for [jurchiks/numbers2words](https://github.com/jurchiks/numbers2words).

### Installation:
```
composer require jurchiks/numbers2words_twig
```

### Configuration:
```php
use \Twig\Environment;
use \js\tools\numbers2words\Speller;
use \js\tools\numbers2words\twig\SpellerExtension;

$extension = new SpellerExtension(Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);
$extension->requireDecimal = true|false; // default true
$extension->spellDecimal = true|false; // default false

$twig = new Environment($loader);
$twig->addExtension($extension);
```

To enable the Twig extension in Symfony, add it in `config/services.yaml` (or its equivalent):
```yaml
services:
    js\tools\numbers2words\twig\SpellerExtension:
        tags: [twig.extension]
        arguments: ['en', 'EUR']
        properties: # optional
            requireDecimal: true
            spellDecimal: false
```

### Usage:

```twig
<p>{{ spellNumber(123) }}</p>
<p>{{ spellCurrency(123.45) }}</p>
<p>{{ spellCurrencyShort(123.45) }}</p>
<p>{{ spellNumber(123, 'ru') }}</p>
<p>{{ spellCurrency(123.45, null, 'RUR') }}</p>
```

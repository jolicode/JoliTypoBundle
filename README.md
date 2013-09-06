This bundle integrate the [JoliTypo](https://github.com/jolicode/JoliTypo) library into Symfony2.

Configuration
=============

Add the Bundle to your Kernel:

```php
  new Joli\TypoBundle\JoliTypoBundle(),
```

Define your Fixers preset as you want:

```yaml
joli_typo:
    presets:
        fr:
            fixers: [ Ellipsis, Dimension, Dash, FrenchQuotes, FrenchNoBreakSpace, CurlyQuote, Trademark ]
            locale: fr_FR
        en:
            fixers: [ Ellipsis, Dimension, Dash, EnglishQuotes, CurlyQuote, Trademark ]
            locale: en_GB
```

Please refer to the [JoliTypo documentation](https://github.com/jolicode/JoliTypo/blob/master/README.md) to learn more about fixers,
and how to combine them.

**Note:** there is no cache involved with JoliTypo, take care of it if you want to save some CPU cycles :grimacing:

Twig function
=============

The Bundle expose a new Twig function and filter named `jolitypo`, waiting for two arguments: HTML content to fix and the preset name.

```twig
{{ jolitypo('<p>Hi folk!</p>', 'fr') | raw }}

{# or #}

{{ '<p>Hi folk!</p>' | jolitypo('fr') }}
```

Another way to use it is by passing a whole block to it:

```twig
{% block content %}
    {{ jolitypo(block('real_content'), 'fr') | raw }}
{% endblock %}

{% block real_content %}
    <h2>My whole dynamic page</h2>
{% endblock %}
```

PHP Template helper
===================

A `jolitypo` helper is available in the view, exposing a `fix` method:

```php
<?php echo $view['jolitypo']->fix('<p>Content</p>', 'en'); ?>
```

Todo
====

- Allow to set service as Fixer via an `@`
- Use Lazy services for all the presets

This bundle integrate the [JoliTypo](https://github.com/jolicode/JoliTypo) library into Symfony2.

Configuration
=============

You define your Fixers preset as you want:

    joli_code_joli_typo:
        presets:
            fr:
                fixers: [ Ellipsis, Dimension, Dash, FrenchQuotes, FrenchNoBreakSpace, CurlyQuote, Trademark ]
                locale: fr_FR
            en:
                fixers: [ Ellipsis, Dimension, Dash, EnglishQuotes, CurlyQuote, Trademark ]
                locale: en_GB

Please refer to the [JoliTypo documentation](https://github.com/jolicode/JoliTypo/blob/master/README.md) to learn more about fixers,
and how to combine them.

Twig function
=============

The Bundle expose a new Twig function `jolitypo` waiting for two arguments: HTML content to fix and the preset name.

    {{ jolitypo('<p>Hi folk!</p>', 'fr') | raw }}

Another way to use it is by passing a whole block to it:

    {% block content %}
        {{ jolitypo(block('real_content'), 'fr') | raw }}
    {% endblock %}

    {% block real_content %}
        <h2>My whole dynamic page</h2>
    {% endblock %}

Todo
====

- Allow to set service as Fixer via an `@`
- Use Lazy services for all the presets

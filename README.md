# Slim Twig Flash

A Twig 3 extension to access Slim Flash messages in templates.

## Install

Via [Composer](https://getcomposer.org/)

```terminal
composer require k-ko/slim-twig-flash
```

Requires:

-   PHP 7.2 or newer
-   Slim Framework Flash Messages 0.1.0 or newer
-   Twig 3 or newer

## Usage

-   Add extension to your twig view

```php
...
$view->addExtension(new Knlv\Slim\Views\TwigMessages(
    new Slim\Flash\Messages()
));
...
```

-   In templates use `flash()` or `flash('some_key')` to fetch messages from Flash service

```html
...
<ul class="alert alert-danger">
	{% for msg in flash('error') %}
	<li>{{ msg }}</li>
	{% endfor %}
</ul>
...
```

## Testing

```terminal
phpunit
```

## License

The GNU GENERAL PUBLIC LICENSE Version 3. Please see [License File](LICENSE) for more information.

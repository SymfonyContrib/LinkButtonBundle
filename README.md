Symfony Contrib Link Button Bundle
==================================

This bundle provides an form extension of a form button to allow an HTML "<a>"
tag as a button. For example, a cancel link on a form.

Installation
============

### 1. Add the bundle to your composer.json

```
"require": {
    ...
    "symfonycontrib/link-button-bundle": "~1.0"
}
```

### 2. Install the bundle using composer

```bash
$ composer update symfonycontrib/link-button-bundle
```

### 3. Add this bundle to your application's kernel:

```php
    new SymfonyContrib\Bundle\LinkButtonBundle\LinkButtonBundle(),
```

How to Use
==========

To use, simply pass a URL to an url option of a form button.

** Example Form **

```php
->add('cancel', 'button', [
    'url' => '/',
]);
```

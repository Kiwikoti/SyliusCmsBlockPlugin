<h1 align="center">Sylius CMS Blocks</h1>

[![Tests Status](https://img.shields.io/github/actions/workflow/status/monsieurbiz/SyliusCmsBlockPlugin/tests.yaml?branch=master&logo=github)](https://github.com/monsieurbiz/SyliusCmsBlockPlugin/actions?query=workflow%3ATests)
[![Recipe Status](https://img.shields.io/github/actions/workflow/status/monsieurbiz/SyliusCmsBlockPlugin/recipe.yaml?branch=master&label=recipes&logo=github)](https://github.com/monsieurbiz/SyliusCmsBlockPlugin/actions?query=workflow%3ASecurity)
[![Security Status](https://img.shields.io/github/actions/workflow/status/monsieurbiz/SyliusCmsBlockPlugin/security.yaml?branch=master&label=security&logo=github)](https://github.com/monsieurbiz/SyliusCmsBlockPlugin/actions?query=workflow%3ASecurity)

## Compatibility

| Sylius Version | PHP Version |
|----------------|-------------|
| 2.0, 2,1       | 8.2 - 8.3   |

ℹ️ For Sylius 1.x, see our [1.x branch](https://github.com/monsieurbiz/SyliusCmsBlockPlugin/tree/1.x) and all 1.x releases.

## Installation

If you want to use our recipes, you can configure your composer.json by running:

```bash
composer config --no-plugins --json extra.symfony.endpoint '["https://api.github.com/repos/monsieurbiz/symfony-recipes/contents/index.json?ref=flex/master","flex://defaults"]'
```

```bash
composer require monsieurbiz/sylius-cms-block-plugin
```

If you do not use the recipes :

Change your `config/bundles.php` file to add the line for the plugin :
```php
<?php
return [
    //..
    MonsieurBiz\SyliusCmsBlockPlugin\MonsieurBizSyliusCmsBlockPlugin::class => ['all' => true],
];
```
Then create the config file in `config/packages/monsieurbiz_sylius_cms_block_plugin.yaml` :
```yaml
imports:
    resource: '@MonsieurBizSyliusCmsBlockPlugin/Resources/config/config.yaml'
```
Finally import the routes in `config/routes/monsieurbiz_sylius_cms_block_plugin.yaml` :
```yaml
imports:
    resource: '@MonsieurBizSyliusCmsBlockPlugin/Resources/config/routes.yaml'
```

If you want to have the wireframe of `block` element in the Rich Editor, copy the file : 

```bash
cp vendor/monsieurbiz/sylius-cms-block-plugin/src/Resources/views/wireframe/block.svg.twig templates/bundles/MonsieurBizSyliusRichEditorPlugin/Wireframe/block.svg.twig
```

### Migrations

First, please run legacy-versioned migrations by using command :
```bash
bin/console doctrine:migrations:migrate
```

## Example

### Admin list

Manage your block in admin

![Grid of blocks in Sylius admin](images/admin-list.jpg)

### Admin form

Manage the content of your block, you can decide to disable or enable it to display it anywhere you used it.

![Form of a block in Sylius Admin](images/admin-form.jpg)

### Include it in your content

For example in your [Homepage](https://github.com/monsieurbiz/SyliusHomepagePlugin) ou [CMS Page](https://github.com/monsieurbiz/SyliusCmsBlockPlugin/), 
by using `block` element in your [Rich Editor](https://github.com/monsieurbiz/SyliusRichEditorPlugin/).

![Block element in rich editor](images/ui-element-card.png)

### Displays in front

You can use it in multiple places, it will shown the same content everywhere.

![Block displayed in front](images/front-example.jpg)

If you disable the block, it will not be displayed anymore.

## License

This plugin is under the MIT license.
Please see the [LICENSE](LICENSE) file for more information.

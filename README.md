# Magento 2 ngrok

Magento 2 module for [ngrok](https://ngrok.com) service support. Automatically updates Magento base url based on domain used in the request. Modifies full-page and block-html caching to separate Magento caches for local and ngrok domains. No broken links or non loaded scripts and styles while browsing Magento web instance.

## Installation

To install the module to your local Magento 2 dev environment, simply run the command below.

```bash
composer require --dev shkoliar/magento-2-ngrok
```

The next step is to check if module is installed and exists in the modules list.

```bash
bin/magento module:status
```

And the last part is enabling the module.

```bash
bin/magento module:enable Shkoliar_Ngrok
```

Optionally you may want to run also `bin/magento setup:upgrade` and `bin/magento setup:di:compile` commands to ensure that the enabled modules are properly registered and classes are generated.

## Usage

Module itself does not require any configuration, it checks for request domain and activated only if it's `.ngrok.io`. So it works only when it needed for [ngrok](https://ngrok.com) secure tunnels.

## License

[MIT](../../blob/master/LICENSE)
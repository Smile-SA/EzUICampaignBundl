# SmileEzUICampaignBundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5bc93a4c-3089-419c-85c2-caa87d625f26/mini.png)](https://insight.sensiolabs.com/projects/5bc93a4c-3089-419c-85c2-caa87d625f26)

> Currently in dev

Add UI Interface to manipulate MailChimp subscriber lists, campaigns 
and add a field type to display a newsletter form subscription. 


## Installation

### Get the bundle using composer

Add SmileEzFieldTypeGeneratorBundle by running this command from the terminal at the root of
your eZPlatform project:

```bash
composer require smile/ez-uicampaign-bundle
```


### Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// ezpublish/EzPublishKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Welp\MailchimpBundle\WelpMailchimpBundle(),
        new Smile\EzUICampaignBundle\SmileEzUICampaignBundle(),
        // ...
    );
}
```

### Configure

add to config.php

```yaml
welp_mailchimp:
    api_key: # your mailchimp api key
```

### Routing

Add to routing.yml

```yaml
smileezcampaign_platform:
    resource: '@SmileEzUICampaignBundle/Resources/config/routing.yml'
```

### Assets

```bash
php app/console assets:install --symlink web

php app/console assetic:dump
```

Add in your layout reference to __smilecampaign.js__

```twig
{% javascripts
    ...
    'bundles/smileezuicampaign/js/smilecampaign.js'
%}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

## TODO

* new campaign
* edit campaign
* delete campaign
* campaign pagination
* send campaign
* send campaign test
* list pagination
* campaign fieldtype

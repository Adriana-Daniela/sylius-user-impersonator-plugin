<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">User Impersonator Plugin</h1>

## Documentation

This is a simple Sylius Plugin designed to help administrators to know when they impersonated a customer within the shop.
This hint consists in showing the string: `Impersonated by {impersonator_username}` in the shop banner, near the customer's name and on the checkout page.

## Quickstart Installation

1. Run `composer require adriana/sylius-impersonator-plugin`.

2. Enable the plugin in `config/bundles.php`:
    ```
    <?php
   
   return [
       //...
       
       Symfony\WebpackEncoreBundle\WebpackEncoreBundle::class => ['all' => true],
       Evo\SyliusUserImpersonatorPlugin\SyliusUserImpersonatorPlugin::class => ['all' => true],
   
       //...
   ];
   ```

3. Ensure you have modified resource configured in `config/packages/_sylius.yaml`:
    ```
   imports:
       - { resource: "@SyliusUserImpersonatorPlugin/Resources/config/app/config.yaml" }
   ```
   
4. Execute migrations in order to have the new field `show_user_impersonate_hint` inside the `channel` table:
    ```bin/console doctrine:migrations:migrate```

5. Add EvoUserImpersonatorChannelTrait in your Channel Entity and extend interface `EvoUserImpersonatorChannelInterface`:
    ```
        namespace  App\Entity\Channel;
    
        use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelInterface;
        use from Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
        
        class Channel extends BaseChannel implements EvoUserImpersonatorChannelInterface
        {
            use EvoUserImpersonatorChannelTrait;
        }
    ```
6. Add translations path in order to use translations in `config/translation.yaml`:
    ```
        framework:
            default_locale: '%locale%'
            translator:
                paths:
                    - '%kernel.project_dir%/translations'
                    - '%kernel.project_dir%/vendor/adriana/sylius-impersonator-plugin/translations' 
   ```
 
7. In order to run Behat tests ensure you have modified your `behat.yml` and configured:
    ```
        imports:
            - vendor/sylius/sylius/src/Sylius/Behat/Resources/config/suites.yml
            - vendor/adriana/sylius-impersonator-plugin/tests/Behat/Resources/config/suites.yml
        .
        .
        .
   
        FriendsOfBehat\SuiteSettingsExtension:
        paths:
            - "vendor/sylius/sylius/features"
            - "features"
            - "vendor/adriana/sylius-impersonator-plugin/features"
    ```

## Usage

Check Admin panel, channels options - edit one channel and the `Show user impersonate hint` option should appear and should be enabled by default.

After that you can impersonate a customer and the `Impersonated by {impersonator_username}` should appear on the shop.

This plugin has a Twig Extension that you can use in any template you need in order to show the impersonate by hint. 
You can use this Extension by calling:

`{{ "sylius.user_impersonator.hint"|trans({"{{impersonator_username}}": userImpersonatorHint()}) }}`

And you can also make usage of the Service created in `Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonator` which you can inject in your application and call its public methods.

## Run Behat Tests

Configure Services path in `config/services_test.yaml`:
```
    - { resource: "../vendor/adriana/sylius-impersonator-plugin/tests/Behat/Resources/config/services.xml" }

```
Run tests with: `APP_ENV=test vendor/bin/behat --suite=adriana_user_impersonator`

<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">User Impersonator Plugin</h1>

## Documentation

This is a simple Sylius Plugin designed to help administrators to know when they impersonated a customer within the shop.
This hint consists in showing the string: `Impersonated by {admin_name}` in the shop banner, near the customer's name and on the checkout page. 

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

3. Ensure you have modified resource configured in `config/packages/_sylius.yaml`
    ```
   imports:
       - { resource: "@SyliusUserImpersonatorPlugin/Resources/config/app/config.yaml" }
   ```
   
4. Execute migrations in order to have the new field `show_user_impersonate_hint` inside the `channel` table:
    ```bin/console doctrine:migrations:migrate```

5. Add EvoUserImpersonatorChannelTrait in your Channel Entity:
    ```
        namespace  App\Entity\Channel;
    
        use from Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
        
        class Channel extends BaseChannel
        {
            use EvoUserImpersonatorChannelTrait;
        }
    ```

6. Now you can check Admin panel, channels options - edit one channel if the 
`Show user impersonate hint` option appears and is enabled.

7. After that you can impersonate a customer and the `Impersonated by {admin_name}` should appear on the shop.

8. In order to run Behat tests ensure you have modified your `behat.yml` and configured:
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

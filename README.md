<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">User Impersonator Plugin</h1>

## Documentation

This is a simple Sylius Plugin designed to help administrators to know when they impersonated a customer within the shop.

## Quickstart Installation

### Traditional

1. Run `composer require adriana/sylius-impersonator-plugin `.

2. Ensure you have modified resource configured in `config/packages/_sylius.yaml`
    ```
   imports:
       - { resource: "@SyliusUserImpersonatorPlugin/Resources/config/app/config.yaml" }
   ```
   
3. Execute migrations:
    ```bin/console doctrine:migrations:migrate```

4. Add EvoUserImpersonatorChannelTrait in Channel Entity:
```
    namespace  App\Entity\Channel;

    use from Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelTrait;
    
    class Channel extends BaseChannel
    {
    use ChannelTrait;
    }
```

5. Now you can check Admin panel, channels options - edit one channel if the 
`Show user impersonate hint` option appears and is enabled

6. After that you can impersonate a customer and the `Impersonated by {admin_name}` should appear on the shop.

7. In order to run Behat tests ensure you have modified your `behat.yml` and configured:
```
    imports:
    - vendor/sylius/sylius/src/Sylius/Behat/Resources/config/suites.yml
    - vendor/evo/sylius-impersonator-plugin/tests/Behat/Resources/config/suites.yml
    .
    .
    .
    FriendsOfBehat\SuiteSettingsExtension:
    paths:
        - "vendor/sylius/sylius/features"
        - "features"
        - "vendor/evo/sylius-impersonator-plugin/features"
```

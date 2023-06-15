<?php

declare(strict_types = 1);

namespace Evo\SyliusUserImpersonatorPlugin\EventSubscriber;

use Sylius\Bundle\UserBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class UserImpersonatorSubscriber implements EventSubscriberInterface
{
    public const IS_SYLIUS_USER_IMPERSONATED = 'is_sylius_user_impersonated';

    public function __construct(private RequestStack $requestStack)
    {
    }


    public static function getSubscribedEvents(): array
    {
        return [
            UserEvents::SECURITY_IMPERSONATE => [
                ['addIsSyliusUserImpersonated', 0]
            ],
            LogoutEvent::class => [
                ['removeIsSyliusUserImpersonated', 0]
            ],
        ];
    }

    public function addIsSyliusUserImpersonated(): void
    {
        $session = $this->requestStack->getSession();
        $session->set(static::IS_SYLIUS_USER_IMPERSONATED, true);
        $session->save();
    }

    public function removeIsSyliusUserImpersonated(): void
    {
        $session = $this->requestStack->getSession();
        if (!$session->has(static::IS_SYLIUS_USER_IMPERSONATED)) {
            return;
        }
        $session->remove(static::IS_SYLIUS_USER_IMPERSONATED);
    }
}

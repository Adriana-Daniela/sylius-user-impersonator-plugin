<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\EventSubscriber;

use Sylius\Bundle\UserBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class UserImpersonateSubscriber implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvents::SECURITY_IMPERSONATE => [
                ['addUserImpersonateSessionKey', 0]
            ],
            LogoutEvent::class => [
                ['removeUserImpersonateSessionKey', 0]
            ],
        ];
    }

    public function addUserImpersonateSessionKey(): void
    {
        $session = $this->requestStack->getSession();
        $session->set('sylius_impersonated_user', true);
        $session->save();
    }

    public function removeUserImpersonateSessionKey(): void
    {
        $session = $this->requestStack->getSession();
        if (!$session->has('sylius_impersonated_user')) {
            return;
        }
        $session->remove('sylius_impersonated_user');
    }
}

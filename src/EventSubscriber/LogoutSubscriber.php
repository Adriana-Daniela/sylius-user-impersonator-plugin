<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => [
                ['processLogout', 0]
            ]
        ];
    }

    public function processLogout(): void
    {
        $session = $this->requestStack->getSession();
        if ($session->get('sylius_impersonated_user') === true) {
            $session->set('sylius_impersonated_user', false);
        }
    }
}

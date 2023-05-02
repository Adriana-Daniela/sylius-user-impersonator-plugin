<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(LogoutEvent $logoutEvent): void
    {
        $session = $this->requestStack->getSession();
        if (!$session->has('sylius_impersonated_user')) {
            return;
        }
        $session->remove('sylius_impersonated_user');
    }
}

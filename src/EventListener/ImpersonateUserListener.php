<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;

class ImpersonateUserListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(): void
    {
        $session = $this->requestStack->getSession();
        $session->set('sylius_impersonated_user', true);
        $session->save();
    }
}

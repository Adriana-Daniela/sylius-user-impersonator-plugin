<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Service;

use Sylius\Component\Core\Model\AdminUser;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckUserImpersonatorService
{
    public function __construct(private RequestStack $requestStack, private Security $security)
    {
    }

    public function check(): ?UserInterface
    {
        if ($this->security->getUser() === null) {
            return null;
        }
        //customer user
        $currentUserRoles = $this->security->getUser()->getRoles();

        //admin user that is able to impersonate bc of the ROLE_SWITCH
        $lastSerializedUsernameToken = $this->requestStack->getSession()->get('_security_admin');

        //token is null if a customer user logs in
        if ($lastSerializedUsernameToken === null) {
            return null;
        }

        /** @var UsernamePasswordToken $userImpersonator */
        $userImpersonator = unserialize($lastSerializedUsernameToken, ['allowed_classes' => [UsernamePasswordToken::class, AdminUser::class]]);
        $userImpersonatorRoles = $userImpersonator->getRoleNames();

        if ($currentUserRoles !== $userImpersonatorRoles && in_array('ROLE_ADMINISTRATION_ACCESS', $userImpersonatorRoles, true)) {
            return $userImpersonator->getUser();
        }

        return null;
    }
}

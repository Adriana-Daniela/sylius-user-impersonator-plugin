<?php

declare(strict_types = 1);

namespace Evo\SyliusUserImpersonatorPlugin\Service;

use Evo\SyliusUserImpersonatorPlugin\Entity\Channel\EvoUserImpersonatorChannelInterface;
use Evo\SyliusUserImpersonatorPlugin\EventSubscriber\UserImpersonatorSubscriber;
use Evo\SyliusUserImpersonatorPlugin\Exception\UserNotFoundException;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CheckUserImpersonator
{
    protected const SECURITY_ADMIN_TOKEN_NAME = '_security_admin';

    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
        private ChannelContextInterface $channelContext,
        private ChannelRepositoryInterface $channelRepository
    ) {
    }

    /**
     * @psalm-suppress UnusedVariable
     */
    public function fetchImpersonatedUser(): UserInterface
    {
        $userImpersonator = $this->fetchUsernamePasswordToken();

        if (null === $userImpersonator?->getUser()) {
            throw new UserNotFoundException('Expected logged in user');
        }

        /** @psalm-ignore-nullable-return */
        return $userImpersonator->getUser();
    }

    public function isUserImpersonated(): bool
    {
        if (null === $this->security->getUser()) {
            return false;
        }

        $currentRequest = $this->requestStack->getCurrentRequest();
        if (null === $currentRequest) {
            return false;
        }

        $session = $currentRequest->getSession();
        if (!$session->has(UserImpersonatorSubscriber::IS_SYLIUS_USER_IMPERSONATED)) {
            return false;
        }

        return ((bool) $session->get(UserImpersonatorSubscriber::IS_SYLIUS_USER_IMPERSONATED)) && $this->isUserImpersonatedHintActiveForCurrentChannel();
    }

    public function fetchUsernamePasswordToken(): ?UsernamePasswordToken
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        if (null === $currentRequest) {
            return null;
        }

        $session = $currentRequest->getSession();
        /** @psalm-param string $usernamePasswordToken */
        $usernamePasswordToken = $session->get(static::SECURITY_ADMIN_TOKEN_NAME);

        if (null === $usernamePasswordToken) {
            return null;
        }

        return unserialize($usernamePasswordToken);
    }

    private function isUserImpersonatedHintActiveForCurrentChannel(): bool
    {
        $currentChannelContext = $this->channelContext->getChannel();
        /** @var EvoUserImpersonatorChannelInterface $currentChannel */
        $currentChannel = $this->channelRepository->find($currentChannelContext->getId());

        return $currentChannel->getShowUserImpersonateHint();
    }
}

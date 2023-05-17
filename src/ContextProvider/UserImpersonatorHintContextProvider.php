<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\ContextProvider;

use Evo\SyliusUserImpersonatorPlugin\Exception\UserNotFoundException;
use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonatorService;
use Sylius\Bundle\UiBundle\ContextProvider\ContextProviderInterface;
use Sylius\Bundle\UiBundle\Registry\TemplateBlock;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sylius.ui.template_event.context_provider')]
class UserImpersonatorHintContextProvider implements ContextProviderInterface
{
    public function __construct(
        private CustomerContextInterface $customerContext,
        private CheckUserImpersonatorService $checkUserImpersonatorService
    ) {
    }

    public function provide(array $templateContext, TemplateBlock $templateBlock): array
    {
        if (!$this->shouldShowUserImpersonateHint()) {
            return $templateContext;
        }

        try {
            $userImpersonator = $this->checkUserImpersonatorService->fetchImpersonatedUser()->getUserIdentifier();
        } catch (UserNotFoundException $e) {
            return $templateContext;
        }

        $this->appendUserImpersonateHintToContext($templateContext, $userImpersonator);

        return $templateContext;

    }

    public function supports(TemplateBlock $templateBlock): bool
    {
        return 'sylius.shop.checkout.header' === $templateBlock->getEventName()
            && 'header' === $templateBlock->getName();
    }

    private function shouldShowUserImpersonateHint(): bool
    {
        $customer = $this->customerContext->getCustomer();
        if ($customer === null) {
            return false;
        }

        if (!$this->checkUserImpersonatorService->isUserImpersonated()) {
            return false;
        }

        return true;
    }

    private function appendUserImpersonateHintToContext(array $templateContext, string $userImpersonator): void
    {
        $customerLastName = $this->customerContext->getCustomer()->getLastName();

        $templateContext['resource']->getCustomer()->setLastName(sprintf('%s' . CheckUserImpersonatorService::USER_IMPERSONATOR_STRING . '%s', $customerLastName, $userImpersonator));
    }
}

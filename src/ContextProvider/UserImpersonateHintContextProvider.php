<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\ContextProvider;

use Evo\SyliusUserImpersonatorPlugin\Exception\UserNotFoundException;
use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonatorService;
use Sylius\Bundle\UiBundle\ContextProvider\ContextProviderInterface;
use Sylius\Bundle\UiBundle\Registry\TemplateBlock;
use Sylius\Component\Customer\Context\CustomerContextInterface;

class UserImpersonateHintContextProvider implements ContextProviderInterface
{
    public function __construct(
        private CustomerContextInterface $customerContext,
        private CheckUserImpersonatorService $checkUserImpersonatorService
    ) {
    }

    public function provide(array $templateContext, TemplateBlock $templateBlock): array
    {
        $customer = $this->customerContext->getCustomer();
        if ($customer === null) {
            return $templateContext;
        }

        if (!$this->checkUserImpersonatorService->isImpersonated()) {
            return $templateContext;
        }

        try {
            $userImpersonator = $this->checkUserImpersonatorService->fetchImpersonatedUser()->getUserIdentifier();
        } catch (UserNotFoundException $e) {
            return $templateContext;
        }

        $customerLastName = $customer->getLastName();

        $templateContext['resource']->getCustomer()->setLastName(sprintf('%s Impersonated by %s', $customerLastName, $userImpersonator));

        return $templateContext;

    }

    public function supports(TemplateBlock $templateBlock): bool
    {
        return 'sylius.shop.checkout.header' === $templateBlock->getEventName()
            && 'header' === $templateBlock->getName();
    }
}

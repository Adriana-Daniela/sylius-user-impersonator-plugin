<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Twig;

use Evo\SyliusUserImpersonatorPlugin\Exception\UserNotFoundException;
use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonatorService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserImpersonatorHintFilterExtension extends AbstractExtension
{
    public function __construct(private CheckUserImpersonatorService $checkUserImpersonatorService)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('userImpersonatorHint', [$this, 'returnUserImpersonatorHint']),
        ];
    }

    public function returnUserImpersonatorHint(): string
    {
        if (!$this->checkUserImpersonatorService->isUserImpersonated()) {
            return '';
        }

        try {
            return sprintf('Impersonated by %s', $this->checkUserImpersonatorService->fetchImpersonatedUser()->getUserIdentifier());
        } catch (UserNotFoundException $e) {
            return '';
        }
    }
}

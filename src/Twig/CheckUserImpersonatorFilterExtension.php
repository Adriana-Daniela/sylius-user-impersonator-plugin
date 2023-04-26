<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Twig;

use Evo\SyliusUserImpersonatorPlugin\Service\CheckUserImpersonatorService;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CheckUserImpersonatorFilterExtension extends AbstractExtension
{
    public function __construct(private CheckUserImpersonatorService $checkUserImpersonatorService)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('checkUserImpersonator', [$this, 'checkUserImpersonator']),
        ];
    }

    public function checkUserImpersonator(): string
    {
        $userImpersonator = $this->checkUserImpersonatorService->check();
        if ($userImpersonator) {
            return sprintf('Impersonated by %s', $userImpersonator->getUserIdentifier());
        }

        return "";
    }
}

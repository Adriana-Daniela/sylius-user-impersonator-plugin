<?php
declare(strict_types=1);

namespace Evo\SyliusUserImpersonatorPlugin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SecurityWidgetController
{
    public function __construct(private Environment $templatingEngine)
    {
    }

    public function renderAction(): Response
    {
        return new Response($this->templatingEngine->render('@SyliusUserImpersonatorPlugin/Menu/_security.html.twig'));
    }
}

<?php
declare(strict_types=1);

namespace Tests\Adriana\SyliusUserImpersonatorPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

class AdminUserContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private ExampleFactoryInterface $userFactory,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @Given there is an administrator :email identified by :username and :password
     */
    public function iAmLoggedInAsAdministratorIdentifiedBy(string $email, string $username, string $password = 'sylius'): void
    {
        /** @var AdminUserInterface $adminUser */
        $adminUser = $this->userFactory->create([
            'email' => $email,
            'password' => $password,
            'enabled' => true,
            'username' => $username,
            'api' => true
        ]);

        $this->userRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }
}

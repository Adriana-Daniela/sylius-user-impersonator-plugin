<?php

declare(strict_types = 1);

namespace Evo\SyliusUserImpersonatorPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230503125545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new bool flag show_user_impersonate_hint on sylius_channel table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_channel ADD show_user_impersonate_hint TINYINT(1) DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_channel DROP show_user_impersonate_hint');
    }
}

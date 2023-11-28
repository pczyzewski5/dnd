<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128192113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create characters table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE characters
(
    id          VARCHAR(36) NOT NULL,
    data        TEXT NOT NULL,
    owner_id    VARCHAR(36) NOT NULL,
    created_at  DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE characters;');
    }
}

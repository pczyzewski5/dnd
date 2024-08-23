<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822180202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates monster table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE monster
(
    id          BINARY(16) NOT NULL,
    name        VARCHAR(72) NOT NULL,
    armor_class TINYINT(2) NOT NULL,
    max_hp  SMALLINT(4) NOT NULL,
    image       TEXT NOT NULL,
    created_at  DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE monster');
    }
}

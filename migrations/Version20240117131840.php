<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117131840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates item_cards table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE item_cards
(
    id          VARCHAR(36) NOT NULL,
    title       VARCHAR(72) NOT NULL,
    description TEXT NOT NULL,
    origin      VARCHAR(72) NOT NULL,
    category    VARCHAR(36) NOT NULL,
    author_id   VARCHAR(36) NOT NULL,
    image       TEXT,
    created_at  DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE item_cards');
    }
}

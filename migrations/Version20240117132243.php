<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117132243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates player_character table';
    }

    public function up(Schema $schema): void
    {
       $sql = <<<SQL
CREATE TABLE player_character
(
    id          BINARY(16) NOT NULL,
    data        TEXT NOT NULL,
    owner_id    BINARY(16) NOT NULL,
    created_at  DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE player_character');
    }
}

<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240827194653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates skill table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE skill
(
    id           BINARY(16) NOT NULL,
    name         VARCHAR(72) NOT NULL,
    description  TEXT NOT NULL,
    is_completed BOOLEAN NOT NULL,
    created_at   DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE skill');
    }
}

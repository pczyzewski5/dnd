<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117132201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates calendar_participants table';
    }

    public function up(Schema $schema): void
    {
       $sql = <<<SQL
CREATE TABLE calendar_participants
(
    calendar_id    VARCHAR(36) NOT NULL,
    participant_id VARCHAR(36) NOT NULL,
    will_attend    TEXT,
    maybe_attend   TEXT,
    wont_attend    TEXT,
    created_at     DATETIME NOT NULL,
    UNIQUE (calendar_id, participant_id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE calendar_participants');
    }
}

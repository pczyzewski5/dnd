<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251104220252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar MODIFY id BINARY(16) NOT NULL;');
        $this->addSql('ALTER TABLE calendar_participant MODIFY calendar_id BINARY(16) NOT NULL;');
        $this->addSql('ALTER TABLE calendar_participant MODIFY participant_id BINARY(16) NOT NULL;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE calendar MODIFY id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE calendar_participant MODIFY calendar_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE calendar_participant MODIFY participant_id VARCHAR(36) NOT NULL');
    }
}

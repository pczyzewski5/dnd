<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241230085419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_proficiency_to_origin (
                proficiency_id INT NOT NULL,
                origin_id INT NOT NULL,
                PRIMARY KEY (proficiency_id, origin_id),
                CONSTRAINT FK_PPTO_PROFICIENCY FOREIGN KEY (proficiency_id) REFERENCES proficiency (id) ON DELETE CASCADE,
                CONSTRAINT FK_PPTO_ORIGIN FOREIGN KEY (origin_id) REFERENCES origin (id) ON DELETE CASCADE
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

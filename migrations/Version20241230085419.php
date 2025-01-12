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

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_proficiency_to_skill (
                proficiency_id INT NOT NULL,
                skill_id INT NOT NULL,
                PRIMARY KEY (proficiency_id, skill_id),
                CONSTRAINT FK_PPTS_PROFICIENCY FOREIGN KEY (proficiency_id) REFERENCES proficiency (id) ON DELETE CASCADE,
                CONSTRAINT FK_PPTS_SKILL FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_proficiency_to_character_class (
                proficiency_id INT NOT NULL,
                character_class_id INT NOT NULL,
                PRIMARY KEY (proficiency_id, character_class_id),
                CONSTRAINT FK_PPTCS_PROFICIENCY FOREIGN KEY (proficiency_id) REFERENCES proficiency (id) ON DELETE CASCADE,
                CONSTRAINT FK_PPTCS_CHARACTER_CLASS FOREIGN KEY (character_class_id) REFERENCES character_class (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_requirement_to_skill (
                requirement_id INT NOT NULL,
                skill_id INT NOT NULL,
                PRIMARY KEY (requirement_id, skill_id),
                CONSTRAINT FK_PRTS_REQUIREMENT FOREIGN KEY (requirement_id) REFERENCES requirement (id) ON DELETE CASCADE,
                CONSTRAINT FK_PRTS_SKILL FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_requirement_to_origin (
                requirement_id INT NOT NULL,
                origin_id INT NOT NULL,
                PRIMARY KEY (requirement_id, origin_id),
                CONSTRAINT FK_PRTO_REQUIREMENT FOREIGN KEY (requirement_id) REFERENCES requirement (id) ON DELETE CASCADE,
                CONSTRAINT FK_PRTO_ORIGIN FOREIGN KEY (origin_id) REFERENCES origin (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_skill_to_race (
                skill_id INT NOT NULL,
                race_id INT NOT NULL,
                PRIMARY KEY (skill_id, race_id),
                CONSTRAINT FK_PSTR_SKILL FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE,
                CONSTRAINT FK_PSTR_RACE FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

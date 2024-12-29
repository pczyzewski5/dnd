<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * php bin/console doctrine:migrations:execute --up 'dnd\Version20241220175957'
 * php bin/console doctrine:migrations:execute --down 'dnd\Version20241220175957'
 */
final class Version20241220175957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE origin (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE race (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                config VARCHAR(510) NOT NULL,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE proficiency (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE (name, category)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_proficiency_to_level (
                proficiency_id INT NOT NULL,
                level_id INT NOT NULL,
                PRIMARY KEY (proficiency_id, level_id),
                CONSTRAINT FK_PPTL_PROFICIENCY FOREIGN KEY (proficiency_id) REFERENCES proficiency (id) ON DELETE CASCADE,
                CONSTRAINT FK_PPTL_LEVEL FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE requirement (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                config VARCHAR(510) NULL,
                PRIMARY KEY (id),
                UNIQUE (name)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_requirement_to_race (
                requirement_id INT NOT NULL,
                race_id INT NOT NULL,
                PRIMARY KEY (requirement_id, race_id),
                CONSTRAINT FK_PRTR_REQUIREMENT FOREIGN KEY (requirement_id) REFERENCES requirement (id) ON DELETE CASCADE,
                CONSTRAINT FK_PRTR_RACE FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE
            );
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_requirement_to_character_class (
                requirement_id INT NOT NULL,
                character_class_id INT NOT NULL,
                PRIMARY KEY (requirement_id, character_class_id),
                CONSTRAINT FK_PRTCC_REQUIREMENT FOREIGN KEY (requirement_id) REFERENCES requirement (id) ON DELETE CASCADE,
                CONSTRAINT FK_PRTCC_CHARACTER_CLASS FOREIGN KEY (character_class_id) REFERENCES character_class (id) ON DELETE CASCADE
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

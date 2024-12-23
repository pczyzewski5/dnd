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
            CREATE TABLE proficiency_to_level (
                level_id INT NOT NULL,
                proficiency_id INT NOT NULL,
                PRIMARY KEY (level_id, proficiency_id),
                CONSTRAINT FK_PTL_LEVEL FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE,
                CONSTRAINT FK_PTL_PROFICIENCY FOREIGN KEY (proficiency_id) REFERENCES proficiency (id) ON DELETE CASCADE
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

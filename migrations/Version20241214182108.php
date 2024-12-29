<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * php bin/console doctrine:migrations:execute --up 'dnd\Version20241214182108'
 * php bin/console doctrine:migrations:execute --down 'dnd\Version20241214182108'
 */
final class Version20241214182108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE level (
                id INT AUTO_INCREMENT NOT NULL, 
                character_class_id INT NOT NULL, 
                level SMALLINT NOT NULL, 
                UNIQUE (character_class_id, level),
                PRIMARY KEY(id),
                CONSTRAINT FK_L_CHARACTER_CLASS FOREIGN KEY (character_class_id) REFERENCES character_class (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE skill (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                description TEXT NOT NULL,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );

        $this->addSql(
            <<<SQL
            CREATE TABLE pivot_skill_to_level (
                level_id INT NOT NULL,
                skill_id INT NOT NULL,
                PRIMARY KEY (level_id, skill_id),
                CONSTRAINT FK_PSTL_LEVEL FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE,
                CONSTRAINT FK_PSTL_SKILL FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE
            );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

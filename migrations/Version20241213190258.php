<?php

declare(strict_types=1);

namespace dnd;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * php bin/console doctrine:migrations:execute --up 'dnd\Version20241213190258'
 * php bin/console doctrine:migrations:execute --down 'dnd\Version20241213190258'
 */
final class Version20241213190258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE character_class (
                id INT NOT NULL AUTO_INCREMENT,
                hit_dice TINYINT NOT NULL,
                name VARCHAR(255) NOT NULL,
                base_class_id INT DEFAULT NULL,
                PRIMARY KEY (id),
                UNIQUE (name),
                CONSTRAINT IDX_BASE_CLASS FOREIGN KEY (base_class_id) REFERENCES character_class (id) ON DELETE SET NULL
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

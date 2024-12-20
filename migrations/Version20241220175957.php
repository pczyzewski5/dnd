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
        $this->addSql('INSERT INTO origin SET name = "folk hero"');

        $this->addSql(
            <<<SQL
            CREATE TABLE race (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL UNIQUE,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB;
            SQL
        );
        $this->addSql('INSERT INTO race SET name = "human"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

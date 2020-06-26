<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625161151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, style VARCHAR(50) NOT NULL, created DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date DATETIME NOT NULL, category VARCHAR(50) DEFAULT NULL, fee INT DEFAULT NULL, fee_currency VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_up (id INT AUTO_INCREMENT NOT NULL, concert_id_id INT NOT NULL, artist_id_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_B1D6FC627AE17470 (concert_id_id), INDEX IDX_B1D6FC621F48AE04 (artist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_up ADD CONSTRAINT FK_B1D6FC627AE17470 FOREIGN KEY (concert_id_id) REFERENCES concert (id)');
        $this->addSql('ALTER TABLE line_up ADD CONSTRAINT FK_B1D6FC621F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_up DROP FOREIGN KEY FK_B1D6FC621F48AE04');
        $this->addSql('ALTER TABLE line_up DROP FOREIGN KEY FK_B1D6FC627AE17470');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE line_up');
        $this->addSql('DROP TABLE user');
    }
}

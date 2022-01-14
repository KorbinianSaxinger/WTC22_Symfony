<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113232208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, conference_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, text VARCHAR(1500) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_9474526C604B8382 (conference_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, year VARCHAR(4) NOT NULL, international TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');

        $this->addSql('INSERT INTO conference values(1,"Hamburg","2022",1)');
        $this->addSql('INSERT INTO conference values(2,"Berlin","2022",0)');

        $this->addSql('INSERT INTO comment values(1,1,"Max Musterman","Super Konferenz in Hamburg gewesen","E@M.ail",null)');
        $this->addSql('INSERT INTO comment values(2,2,"Muster Frau","Super Konferenz in Berlin gewesen","E@M.ail",null)');
        $this->addSql('INSERT INTO comment values(3,2,"Max Musterman","Super Konferenz in Berlin gewesen","E@M.ail",null)');
        $this->addSql('INSERT INTO comment values(4,1,"Muster Frau","Super Konferenz in Hamburg gewesen","E@M.ail",null)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C604B8382');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE conference');
    }
}

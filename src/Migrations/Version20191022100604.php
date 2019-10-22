<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191022100604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Author entity creation';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO author (name, email) VALUES ("anonymous", "anonymous@null.com")');
        $this->addSql('ALTER TABLE article ADD written_by_id INT');
        $this->addSql('UPDATE article a SET a.written_by_id = 1');
        $this->addSql('ALTER TABLE article MODIFY COLUMN written_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66AB69C8EF FOREIGN KEY (written_by_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66AB69C8EF ON article (written_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66AB69C8EF');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP INDEX IDX_23A0E66AB69C8EF ON article');
        $this->addSql('ALTER TABLE article DROP written_by_id');
    }
}

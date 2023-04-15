<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415161524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, niveau_id INT NOT NULL, plante_id INT NOT NULL, is_planted BOOLEAN NOT NULL, has_grown BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251EB3E9C81 ON item (niveau_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E177B16E8 ON item (plante_id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EB3E9C81');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E177B16E8');
        $this->addSql('DROP TABLE item');
    }
}

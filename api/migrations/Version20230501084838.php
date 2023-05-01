<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501084838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE demande_blogger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE demande_blogger (id INT NOT NULL, user_id_id UUID NOT NULL, motif TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_980E8B4D9D86650F ON demande_blogger (user_id_id)');
        $this->addSql('COMMENT ON COLUMN demande_blogger.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN demande_blogger.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE demande_blogger ADD CONSTRAINT FK_980E8B4D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE demande_blogger_id_seq CASCADE');
        $this->addSql('ALTER TABLE demande_blogger DROP CONSTRAINT FK_980E8B4D9D86650F');
        $this->addSql('DROP TABLE demande_blogger');
    }
}

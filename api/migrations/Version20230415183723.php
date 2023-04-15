<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415183723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE blog_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE blog (id INT NOT NULL, plante_id INT NOT NULL, user_id_id UUID NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, area TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0155143177B16E8 ON blog (plante_id)');
        $this->addSql('CREATE INDEX IDX_C01551439D86650F ON blog (user_id_id)');
        $this->addSql('COMMENT ON COLUMN blog.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN blog.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551439D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE blog_id_seq CASCADE');
        $this->addSql('ALTER TABLE blog DROP CONSTRAINT FK_C0155143177B16E8');
        $this->addSql('ALTER TABLE blog DROP CONSTRAINT FK_C01551439D86650F');
        $this->addSql('DROP TABLE blog');
    }
}

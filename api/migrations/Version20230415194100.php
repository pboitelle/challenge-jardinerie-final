<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415194100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE vente_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vente (id INT NOT NULL, vendeur_id UUID NOT NULL, acheteur_id UUID NOT NULL, item_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_888A2A4C858C065E ON vente (vendeur_id)');
        $this->addSql('CREATE INDEX IDX_888A2A4C96A7BB5F ON vente (acheteur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_888A2A4C126F525E ON vente (item_id)');
        $this->addSql('COMMENT ON COLUMN vente.vendeur_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN vente.acheteur_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C858C065E FOREIGN KEY (vendeur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4C126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE vente_id_seq CASCADE');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4C858C065E');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4C96A7BB5F');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4C126F525E');
        $this->addSql('DROP TABLE vente');
    }
}

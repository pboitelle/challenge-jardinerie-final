<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415185944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE market_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE market (id INT NOT NULL, user_id_id UUID NOT NULL, item_id_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6BAC85CB9D86650F ON market (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BAC85CB55E38587 ON market (item_id_id)');
        $this->addSql('COMMENT ON COLUMN market.user_id_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CB9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CB55E38587 FOREIGN KEY (item_id_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE market_id_seq CASCADE');
        $this->addSql('ALTER TABLE market DROP CONSTRAINT FK_6BAC85CB9D86650F');
        $this->addSql('ALTER TABLE market DROP CONSTRAINT FK_6BAC85CB55E38587');
        $this->addSql('DROP TABLE market');
    }
}

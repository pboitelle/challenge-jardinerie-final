<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919095850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hackathon_user (hackathon_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(hackathon_id, user_id))');
        $this->addSql('CREATE INDEX IDX_58930177996D90CF ON hackathon_user (hackathon_id)');
        $this->addSql('CREATE INDEX IDX_58930177A76ED395 ON hackathon_user (user_id)');
        $this->addSql('ALTER TABLE hackathon_user ADD CONSTRAINT FK_58930177996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon_user ADD CONSTRAINT FK_58930177A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE hackathon_user');
    }
}

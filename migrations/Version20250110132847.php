<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110132847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE requests ADD user_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE requests ADD CONSTRAINT FK_7B85D651E5197E49 FOREIGN KEY (user_request_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7B85D651E5197E49 ON requests (user_request_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE requests DROP CONSTRAINT FK_7B85D651E5197E49');
        $this->addSql('DROP INDEX IDX_7B85D651E5197E49');
        $this->addSql('ALTER TABLE requests DROP user_request_id');
    }
}

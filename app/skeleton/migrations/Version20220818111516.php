<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818111516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party ALTER date_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE party ALTER date_at DROP DEFAULT');
        $this->addSql('ALTER TABLE party ALTER date_at SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN party.date_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party ALTER date_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE party ALTER date_at DROP DEFAULT');
        $this->addSql('ALTER TABLE party ALTER date_at DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN party.date_at IS \'(DC2Type:datetime_immutable)\'');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815170740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cheque ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE9F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A0BBFDE9F675F31B ON cheque (author_id)');
        $this->addSql('ALTER TABLE guest ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest ADD by_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35DC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_ACB79A35F675F31B ON guest (author_id)');
        $this->addSql('CREATE INDEX IDX_ACB79A35DC9C2434 ON guest (by_user_id)');
        $this->addSql('ALTER TABLE party ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_89954EE0F675F31B ON party (author_id)');
        $this->addSql('ALTER TABLE payment ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840DF675F31B ON payment (author_id)');
        $this->addSql('ALTER TABLE product ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0F675F31B');
        $this->addSql('DROP INDEX IDX_89954EE0F675F31B');
        $this->addSql('ALTER TABLE party DROP author_id');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A35F675F31B');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A35DC9C2434');
        $this->addSql('DROP INDEX IDX_ACB79A35F675F31B');
        $this->addSql('DROP INDEX IDX_ACB79A35DC9C2434');
        $this->addSql('ALTER TABLE guest DROP author_id');
        $this->addSql('ALTER TABLE guest DROP by_user_id');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DF675F31B');
        $this->addSql('DROP INDEX IDX_6D28840DF675F31B');
        $this->addSql('ALTER TABLE payment DROP author_id');
        $this->addSql('ALTER TABLE cheque DROP CONSTRAINT FK_A0BBFDE9F675F31B');
        $this->addSql('DROP INDEX IDX_A0BBFDE9F675F31B');
        $this->addSql('ALTER TABLE cheque DROP author_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADF675F31B');
        $this->addSql('DROP INDEX IDX_D34A04ADF675F31B');
        $this->addSql('ALTER TABLE product DROP author_id');
    }
}

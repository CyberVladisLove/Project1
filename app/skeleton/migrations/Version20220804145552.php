<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804145552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guest_product (guest_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(guest_id, product_id))');
        $this->addSql('CREATE INDEX IDX_938FC0E19A4AA658 ON guest_product (guest_id)');
        $this->addSql('CREATE INDEX IDX_938FC0E14584665A ON guest_product (product_id)');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E19A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cheque ADD customer_guest_id INT NOT NULL');
        $this->addSql('ALTER TABLE cheque ADD CONSTRAINT FK_A0BBFDE9B68FE577 FOREIGN KEY (customer_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A0BBFDE9B68FE577 ON cheque (customer_guest_id)');
        $this->addSql('ALTER TABLE product ADD cheque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DD3DB4B FOREIGN KEY (cheque_id) REFERENCES cheque (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04AD3DD3DB4B ON product (cheque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE guest_product');
        $this->addSql('ALTER TABLE cheque DROP CONSTRAINT FK_A0BBFDE9B68FE577');
        $this->addSql('DROP INDEX IDX_A0BBFDE9B68FE577');
        $this->addSql('ALTER TABLE cheque DROP customer_guest_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD3DD3DB4B');
        $this->addSql('DROP INDEX IDX_D34A04AD3DD3DB4B');
        $this->addSql('ALTER TABLE product DROP cheque_id');
    }
}

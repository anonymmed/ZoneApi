<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020002401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD variation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD5182BFD8 ON product (variation_id)');
        $this->addSql('ALTER TABLE variation DROP FOREIGN KEY FK_629B33EA4584665A');
        $this->addSql('DROP INDEX UNIQ_629B33EA4584665A ON variation');
        $this->addSql('ALTER TABLE variation DROP product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5182BFD8');
        $this->addSql('DROP INDEX UNIQ_D34A04AD5182BFD8 ON product');
        $this->addSql('ALTER TABLE product DROP variation_id');
        $this->addSql('ALTER TABLE variation ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variation ADD CONSTRAINT FK_629B33EA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_629B33EA4584665A ON variation (product_id)');
    }
}

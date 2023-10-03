<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003050204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, posting_id INT DEFAULT NULL, identity_id INT DEFAULT NULL, created_at DATETIME NOT NULL, other VARCHAR(255) DEFAULT NULL, INDEX IDX_A45BDDC19AE985F6 (posting_id), INDEX IDX_A45BDDC1FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC19AE985F6 FOREIGN KEY (posting_id) REFERENCES posting (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC19AE985F6');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1FF3ED4A8');
        $this->addSql('DROP TABLE application');
    }
}

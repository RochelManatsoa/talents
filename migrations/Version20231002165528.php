<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002165528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expert (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, years VARCHAR(50) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, main_skills LONGTEXT DEFAULT NULL, aspiration LONGTEXT DEFAULT NULL, preference LONGTEXT DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4F1B9342FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expert ADD CONSTRAINT FK_4F1B9342FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expert DROP FOREIGN KEY FK_4F1B9342FF3ED4A8');
        $this->addSql('DROP TABLE expert');
        $this->addSql('DROP TABLE sector');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011205035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posting_technical_skill (posting_id INT NOT NULL, technical_skill_id INT NOT NULL, INDEX IDX_B0FD749AE985F6 (posting_id), INDEX IDX_B0FD74E98F0EFD (technical_skill_id), PRIMARY KEY(posting_id, technical_skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posting_language (posting_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_51582A6B9AE985F6 (posting_id), INDEX IDX_51582A6B82F1BAF4 (language_id), PRIMARY KEY(posting_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posting_technical_skill ADD CONSTRAINT FK_B0FD749AE985F6 FOREIGN KEY (posting_id) REFERENCES posting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_technical_skill ADD CONSTRAINT FK_B0FD74E98F0EFD FOREIGN KEY (technical_skill_id) REFERENCES technical_skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_language ADD CONSTRAINT FK_51582A6B9AE985F6 FOREIGN KEY (posting_id) REFERENCES posting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_language ADD CONSTRAINT FK_51582A6B82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posting_technical_skill DROP FOREIGN KEY FK_B0FD749AE985F6');
        $this->addSql('ALTER TABLE posting_technical_skill DROP FOREIGN KEY FK_B0FD74E98F0EFD');
        $this->addSql('ALTER TABLE posting_language DROP FOREIGN KEY FK_51582A6B9AE985F6');
        $this->addSql('ALTER TABLE posting_language DROP FOREIGN KEY FK_51582A6B82F1BAF4');
        $this->addSql('DROP TABLE posting_technical_skill');
        $this->addSql('DROP TABLE posting_language');
    }
}

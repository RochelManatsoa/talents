<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003044808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, currently TINYINT(1) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_590C103FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_note (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, technical_skill_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_88FC66A6FF3ED4A8 (identity_id), INDEX IDX_88FC66A6E98F0EFD (technical_skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spoken_language (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, language_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, level VARCHAR(255) DEFAULT NULL, INDEX IDX_A861E9D8FF3ED4A8 (identity_id), INDEX IDX_A861E9D882F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_skill_identity (technical_skill_id INT NOT NULL, identity_id INT NOT NULL, INDEX IDX_B1DBD8CE98F0EFD (technical_skill_id), INDEX IDX_B1DBD8CFF3ED4A8 (identity_id), PRIMARY KEY(technical_skill_id, identity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_skill_technical_skill (technical_skill_source INT NOT NULL, technical_skill_target INT NOT NULL, INDEX IDX_5333EBD9971AB3FB (technical_skill_source), INDEX IDX_5333EBD98EFFE374 (technical_skill_target), PRIMARY KEY(technical_skill_source, technical_skill_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE skill_note ADD CONSTRAINT FK_88FC66A6FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE skill_note ADD CONSTRAINT FK_88FC66A6E98F0EFD FOREIGN KEY (technical_skill_id) REFERENCES technical_skill (id)');
        $this->addSql('ALTER TABLE spoken_language ADD CONSTRAINT FK_A861E9D8FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE spoken_language ADD CONSTRAINT FK_A861E9D882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE technical_skill_identity ADD CONSTRAINT FK_B1DBD8CE98F0EFD FOREIGN KEY (technical_skill_id) REFERENCES technical_skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technical_skill_identity ADD CONSTRAINT FK_B1DBD8CFF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technical_skill_technical_skill ADD CONSTRAINT FK_5333EBD9971AB3FB FOREIGN KEY (technical_skill_source) REFERENCES technical_skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technical_skill_technical_skill ADD CONSTRAINT FK_5333EBD98EFFE374 FOREIGN KEY (technical_skill_target) REFERENCES technical_skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103FF3ED4A8');
        $this->addSql('ALTER TABLE skill_note DROP FOREIGN KEY FK_88FC66A6FF3ED4A8');
        $this->addSql('ALTER TABLE skill_note DROP FOREIGN KEY FK_88FC66A6E98F0EFD');
        $this->addSql('ALTER TABLE spoken_language DROP FOREIGN KEY FK_A861E9D8FF3ED4A8');
        $this->addSql('ALTER TABLE spoken_language DROP FOREIGN KEY FK_A861E9D882F1BAF4');
        $this->addSql('ALTER TABLE technical_skill_identity DROP FOREIGN KEY FK_B1DBD8CE98F0EFD');
        $this->addSql('ALTER TABLE technical_skill_identity DROP FOREIGN KEY FK_B1DBD8CFF3ED4A8');
        $this->addSql('ALTER TABLE technical_skill_technical_skill DROP FOREIGN KEY FK_5333EBD9971AB3FB');
        $this->addSql('ALTER TABLE technical_skill_technical_skill DROP FOREIGN KEY FK_5333EBD98EFFE374');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE skill_note');
        $this->addSql('DROP TABLE spoken_language');
        $this->addSql('DROP TABLE technical_skill');
        $this->addSql('DROP TABLE technical_skill_identity');
        $this->addSql('DROP TABLE technical_skill_technical_skill');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003031346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posting (id INT AUTO_INCREMENT NOT NULL, sector_id INT DEFAULT NULL, company_id INT DEFAULT NULL, type_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, tarif VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updates_at DATETIME DEFAULT NULL, number INT DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, job_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', planned_date DATETIME DEFAULT NULL, INDEX IDX_BD275D73DE95C867 (sector_id), INDEX IDX_BD275D73979B1AD6 (company_id), INDEX IDX_BD275D73C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posting_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posting_type_company (posting_type_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_4C80D56623278AC1 (posting_type_id), INDEX IDX_4C80D566979B1AD6 (company_id), PRIMARY KEY(posting_type_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posting_type_expert (posting_type_id INT NOT NULL, expert_id INT NOT NULL, INDEX IDX_C625B6C023278AC1 (posting_type_id), INDEX IDX_C625B6C0C5568CE4 (expert_id), PRIMARY KEY(posting_type_id, expert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posting_views (id INT AUTO_INCREMENT NOT NULL, posting_id INT DEFAULT NULL, ip_adress VARCHAR(255) DEFAULT NULL, INDEX IDX_269EFECA9AE985F6 (posting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posting ADD CONSTRAINT FK_BD275D73DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE posting ADD CONSTRAINT FK_BD275D73979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE posting ADD CONSTRAINT FK_BD275D73C54C8C93 FOREIGN KEY (type_id) REFERENCES posting_type (id)');
        $this->addSql('ALTER TABLE posting_type_company ADD CONSTRAINT FK_4C80D56623278AC1 FOREIGN KEY (posting_type_id) REFERENCES posting_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_type_company ADD CONSTRAINT FK_4C80D566979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_type_expert ADD CONSTRAINT FK_C625B6C023278AC1 FOREIGN KEY (posting_type_id) REFERENCES posting_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_type_expert ADD CONSTRAINT FK_C625B6C0C5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posting_views ADD CONSTRAINT FK_269EFECA9AE985F6 FOREIGN KEY (posting_id) REFERENCES posting (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posting DROP FOREIGN KEY FK_BD275D73DE95C867');
        $this->addSql('ALTER TABLE posting DROP FOREIGN KEY FK_BD275D73979B1AD6');
        $this->addSql('ALTER TABLE posting DROP FOREIGN KEY FK_BD275D73C54C8C93');
        $this->addSql('ALTER TABLE posting_type_company DROP FOREIGN KEY FK_4C80D56623278AC1');
        $this->addSql('ALTER TABLE posting_type_company DROP FOREIGN KEY FK_4C80D566979B1AD6');
        $this->addSql('ALTER TABLE posting_type_expert DROP FOREIGN KEY FK_C625B6C023278AC1');
        $this->addSql('ALTER TABLE posting_type_expert DROP FOREIGN KEY FK_C625B6C0C5568CE4');
        $this->addSql('ALTER TABLE posting_views DROP FOREIGN KEY FK_269EFECA9AE985F6');
        $this->addSql('DROP TABLE posting');
        $this->addSql('DROP TABLE posting_type');
        $this->addSql('DROP TABLE posting_type_company');
        $this->addSql('DROP TABLE posting_type_expert');
        $this->addSql('DROP TABLE posting_views');
    }
}

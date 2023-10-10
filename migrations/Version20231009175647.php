<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009175647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, level VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_identity (formation_id INT NOT NULL, identity_id INT NOT NULL, INDEX IDX_AD07BE355200282E (formation_id), INDEX IDX_AD07BE35FF3ED4A8 (identity_id), PRIMARY KEY(formation_id, identity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, skype VARCHAR(255) DEFAULT NULL, slack VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7161E187FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_identity ADD CONSTRAINT FK_AD07BE355200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_identity ADD CONSTRAINT FK_AD07BE35FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE social ADD CONSTRAINT FK_7161E187FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_identity DROP FOREIGN KEY FK_AD07BE355200282E');
        $this->addSql('ALTER TABLE formation_identity DROP FOREIGN KEY FK_AD07BE35FF3ED4A8');
        $this->addSql('ALTER TABLE social DROP FOREIGN KEY FK_7161E187FF3ED4A8');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_identity');
        $this->addSql('DROP TABLE social');
    }
}

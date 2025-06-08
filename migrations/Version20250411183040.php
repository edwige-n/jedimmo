<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250411183040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('CREATE TABLE contribution (id INT AUTO_INCREMENT NOT NULL, contributor_id INT DEFAULT NULL, project_id INT DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_EA351E157A19A357 (contributor_id), INDEX IDX_EA351E15166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, projectname VARCHAR(40) DEFAULT NULL, descripton VARCHAR(200) DEFAULT NULL, goal_amount DOUBLE PRECISION DEFAULT NULL, statut VARCHAR(20) DEFAULT NULL, yield DOUBLE PRECISION DEFAULT NULL, duration INT DEFAULT NULL, current_amount DOUBLE PRECISION DEFAULT NULL, projectimage VARCHAR(255) DEFAULT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_2FB3D0EE61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(40) DEFAULT NULL, firstname VARCHAR(40) DEFAULT NULL, email VARCHAR(140) DEFAULT NULL, statut VARCHAR(20) DEFAULT NULL, profile_pic LONGBLOB DEFAULT NULL, password VARCHAR(90) DEFAULT NULL, roles JSON DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E157A19A357');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15166D1F9C');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE61220EA6');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');

    }
}

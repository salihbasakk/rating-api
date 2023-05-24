<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524101446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(96) NOT NULL, last_name VARCHAR(96) NOT NULL, username VARCHAR(128) NOT NULL COMMENT \'Email as the username\', password VARCHAR(96) NOT NULL COMMENT \'Use password hash with BCRYPT\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_70E4FA78F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, project INT DEFAULT NULL, client INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, overall_rating DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D22944582FB3D0EE (project), INDEX IDX_D2294458C7440455 (client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, vico_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EE19F89217 (vico_id), INDEX creator_idx (creator_id), INDEX created_at_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, feedback INT DEFAULT NULL, rating_question INT DEFAULT NULL, score DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D8892622D2294458 (feedback), INDEX IDX_D8892622E8CAFCB9 (rating_question), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_question (id INT AUTO_INCREMENT NOT NULL, project INT DEFAULT NULL, question VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E8CAFCB92FB3D0EE (project), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vico (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX name_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944582FB3D0EE FOREIGN KEY (project) REFERENCES project (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458C7440455 FOREIGN KEY (client) REFERENCES client (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19F89217 FOREIGN KEY (vico_id) REFERENCES vico (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE61220EA6 FOREIGN KEY (creator_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D2294458 FOREIGN KEY (feedback) REFERENCES feedback (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622E8CAFCB9 FOREIGN KEY (rating_question) REFERENCES rating_question (id)');
        $this->addSql('ALTER TABLE rating_question ADD CONSTRAINT FK_E8CAFCB92FB3D0EE FOREIGN KEY (project) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D22944582FB3D0EE');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458C7440455');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE19F89217');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE61220EA6');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622D2294458');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622E8CAFCB9');
        $this->addSql('ALTER TABLE rating_question DROP FOREIGN KEY FK_E8CAFCB92FB3D0EE');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE rating_question');
        $this->addSql('DROP TABLE vico');
    }
}

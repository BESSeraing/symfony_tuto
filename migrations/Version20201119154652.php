<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119154652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, content LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, last_update DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A25B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, advert_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_B6F7494ED07ECCB6 (advert_id), INDEX IDX_B6F7494EB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE advert ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BB03A8386 ON advert (created_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BB03A8386');
        $this->addSql('DROP INDEX IDX_54F1F40BB03A8386 ON advert');
        $this->addSql('ALTER TABLE advert DROP created_by_id');
    }
}

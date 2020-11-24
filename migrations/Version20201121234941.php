<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121234941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, keyword VARCHAR(255) DEFAULT NULL, frame_type VARCHAR(255) DEFAULT NULL, frame_size VARCHAR(255) DEFAULT NULL, price_min INT DEFAULT NULL, price_max INT DEFAULT NULL, INDEX IDX_B4F0DBA712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_tag (search_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C732C33C650760A9 (search_id), INDEX IDX_C732C33CBAD26311 (tag_id), PRIMARY KEY(search_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search ADD CONSTRAINT FK_B4F0DBA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE search_tag ADD CONSTRAINT FK_C732C33C650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_tag ADD CONSTRAINT FK_C732C33CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_tag DROP FOREIGN KEY FK_C732C33C650760A9');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE search_tag');
    }
}

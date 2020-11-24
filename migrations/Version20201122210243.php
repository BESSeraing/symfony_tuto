<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122210243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search_category (search_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_161BB274650760A9 (search_id), INDEX IDX_161BB27412469DE2 (category_id), PRIMARY KEY(search_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search_category ADD CONSTRAINT FK_161BB274650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_category ADD CONSTRAINT FK_161BB27412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search DROP FOREIGN KEY FK_B4F0DBA712469DE2');
        $this->addSql('DROP INDEX IDX_B4F0DBA712469DE2 ON search');
        $this->addSql('ALTER TABLE search ADD frame_sizes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD frame_types LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP category_id, DROP frame_type, DROP frame_size');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE search_category');
        $this->addSql('ALTER TABLE search ADD category_id INT DEFAULT NULL, ADD frame_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD frame_size VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP frame_sizes, DROP frame_types');
        $this->addSql('ALTER TABLE search ADD CONSTRAINT FK_B4F0DBA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B4F0DBA712469DE2 ON search (category_id)');
    }
}

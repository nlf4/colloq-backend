<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530123909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE avail_start_date avail_start_date DATE DEFAULT NULL, CHANGE avail_end_date avail_end_date DATE DEFAULT NULL, CHANGE is_tourist is_tourist TINYINT(1) DEFAULT NULL, CHANGE is_tutor is_tutor TINYINT(1) DEFAULT NULL, CHANGE meetup_type meetup_type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE avail_start_date avail_start_date DATE NOT NULL, CHANGE avail_end_date avail_end_date DATE NOT NULL, CHANGE is_tourist is_tourist TINYINT(1) NOT NULL, CHANGE is_tutor is_tutor TINYINT(1) NOT NULL, CHANGE meetup_type meetup_type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}

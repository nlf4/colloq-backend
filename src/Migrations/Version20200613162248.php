<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613162248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meetup ADD creator_id INT DEFAULT NULL, ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meetup ADD CONSTRAINT FK_9377E2861220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meetup ADD CONSTRAINT FK_9377E289D1C3019 FOREIGN KEY (participant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9377E2861220EA6 ON meetup (creator_id)');
        $this->addSql('CREATE INDEX IDX_9377E289D1C3019 ON meetup (participant_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meetup DROP FOREIGN KEY FK_9377E2861220EA6');
        $this->addSql('ALTER TABLE meetup DROP FOREIGN KEY FK_9377E289D1C3019');
        $this->addSql('DROP INDEX IDX_9377E2861220EA6 ON meetup');
        $this->addSql('DROP INDEX IDX_9377E289D1C3019 ON meetup');
        $this->addSql('ALTER TABLE meetup DROP creator_id, DROP participant_id');

    }
}

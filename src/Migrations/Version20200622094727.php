<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622094727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD native_language_id INT DEFAULT NULL, ADD target_language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F44D7B10 FOREIGN KEY (native_language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495CBF5FE FOREIGN KEY (target_language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F44D7B10 ON user (native_language_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495CBF5FE ON user (target_language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F44D7B10');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495CBF5FE');
        $this->addSql('DROP INDEX IDX_8D93D649F44D7B10 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6495CBF5FE ON user');
        $this->addSql('ALTER TABLE user DROP native_language_id, DROP target_language_id');
    }
}

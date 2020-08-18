<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818095927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE social_links DROP FOREIGN KEY FK_9B12158A9D6A1065');
        $this->addSql('DROP INDEX IDX_9B12158A9D6A1065 ON social_links');
        $this->addSql('ALTER TABLE social_links CHANGE events_id event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_links ADD CONSTRAINT FK_9B12158A71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('CREATE INDEX IDX_9B12158A71F7E88B ON social_links (event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE social_links DROP FOREIGN KEY FK_9B12158A71F7E88B');
        $this->addSql('DROP INDEX IDX_9B12158A71F7E88B ON social_links');
        $this->addSql('ALTER TABLE social_links CHANGE event_id events_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_links ADD CONSTRAINT FK_9B12158A9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id)');
        $this->addSql('CREATE INDEX IDX_9B12158A9D6A1065 ON social_links (events_id)');
    }
}

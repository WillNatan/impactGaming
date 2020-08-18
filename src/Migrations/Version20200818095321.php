<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818095321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE events_social_links');
        $this->addSql('ALTER TABLE social_links ADD events_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social_links ADD CONSTRAINT FK_9B12158A9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id)');
        $this->addSql('CREATE INDEX IDX_9B12158A9D6A1065 ON social_links (events_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE events_social_links (events_id INT NOT NULL, social_links_id INT NOT NULL, INDEX IDX_2812E7A9D6A1065 (events_id), INDEX IDX_2812E7A4EEFCCA1 (social_links_id), PRIMARY KEY(events_id, social_links_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE events_social_links ADD CONSTRAINT FK_2812E7A4EEFCCA1 FOREIGN KEY (social_links_id) REFERENCES social_links (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_social_links ADD CONSTRAINT FK_2812E7A9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE social_links DROP FOREIGN KEY FK_9B12158A9D6A1065');
        $this->addSql('DROP INDEX IDX_9B12158A9D6A1065 ON social_links');
        $this->addSql('ALTER TABLE social_links DROP events_id');
    }
}

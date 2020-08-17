<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816073214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE available_games (id INT AUTO_INCREMENT NOT NULL, game_name VARCHAR(255) NOT NULL, game_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_reviews (id INT AUTO_INCREMENT NOT NULL, events_id INT DEFAULT NULL, rating INT NOT NULL, body LONGTEXT NOT NULL, INDEX IDX_EC2742A09D6A1065 (events_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, website_link VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, launch_date DATE NOT NULL, stop_date DATE NOT NULL, short_desc LONGTEXT NOT NULL, long_desc LONGTEXT NOT NULL, price DOUBLE PRECISION DEFAULT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, ticket_number INT DEFAULT NULL, INDEX IDX_5387574A12469DE2 (category_id), INDEX IDX_5387574AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_social_links (events_id INT NOT NULL, social_links_id INT NOT NULL, INDEX IDX_2812E7A9D6A1065 (events_id), INDEX IDX_2812E7A4EEFCCA1 (social_links_id), PRIMARY KEY(events_id, social_links_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_available_games (events_id INT NOT NULL, available_games_id INT NOT NULL, INDEX IDX_34381CF99D6A1065 (events_id), INDEX IDX_34381CF98C753523 (available_games_id), PRIMARY KEY(events_id, available_games_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_links (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, event_reviews_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D87C0050 (event_reviews_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_reviews ADD CONSTRAINT FK_EC2742A09D6A1065 FOREIGN KEY (events_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A12469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE events_social_links ADD CONSTRAINT FK_2812E7A9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_social_links ADD CONSTRAINT FK_2812E7A4EEFCCA1 FOREIGN KEY (social_links_id) REFERENCES social_links (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_available_games ADD CONSTRAINT FK_34381CF99D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_available_games ADD CONSTRAINT FK_34381CF98C753523 FOREIGN KEY (available_games_id) REFERENCES available_games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D87C0050 FOREIGN KEY (event_reviews_id) REFERENCES event_reviews (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events_available_games DROP FOREIGN KEY FK_34381CF98C753523');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A12469DE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D87C0050');
        $this->addSql('ALTER TABLE event_reviews DROP FOREIGN KEY FK_EC2742A09D6A1065');
        $this->addSql('ALTER TABLE events_social_links DROP FOREIGN KEY FK_2812E7A9D6A1065');
        $this->addSql('ALTER TABLE events_available_games DROP FOREIGN KEY FK_34381CF99D6A1065');
        $this->addSql('ALTER TABLE events_social_links DROP FOREIGN KEY FK_2812E7A4EEFCCA1');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE available_games');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE event_reviews');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE events_social_links');
        $this->addSql('DROP TABLE events_available_games');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE social_links');
        $this->addSql('DROP TABLE user');
    }
}

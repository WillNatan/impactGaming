<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912084827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, department_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_platform (events_id INT NOT NULL, platform_id INT NOT NULL, INDEX IDX_C46648C89D6A1065 (events_id), INDEX IDX_C46648C8FFE6496F (platform_id), PRIMARY KEY(events_id, platform_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, platform_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_platform ADD CONSTRAINT FK_C46648C89D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_platform ADD CONSTRAINT FK_C46648C8FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events ADD department_id INT DEFAULT NULL, DROP department, DROP support');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_5387574AAE80F5DF ON events (department_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AAE80F5DF');
        $this->addSql('ALTER TABLE events_platform DROP FOREIGN KEY FK_C46648C8FFE6496F');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE events_platform');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP INDEX IDX_5387574AAE80F5DF ON events');
        $this->addSql('ALTER TABLE events ADD department VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD support LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', DROP department_id');
    }
}

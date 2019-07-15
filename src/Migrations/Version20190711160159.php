<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190711160159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066AEF5A6C1');
        $this->addSql('DROP INDEX IDX_DE4CF066AEF5A6C1 ON employer');
        $this->addSql('ALTER TABLE employer CHANGE datenaissance datenaissance DATETIME NOT NULL, CHANGE services_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_DE4CF066ED5CA9E6 ON employer (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066ED5CA9E6');
        $this->addSql('DROP INDEX IDX_DE4CF066ED5CA9E6 ON employer');
        $this->addSql('ALTER TABLE employer CHANGE datenaissance datenaissance DATE NOT NULL, CHANGE service_id services_id INT NOT NULL');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_DE4CF066AEF5A6C1 ON employer (services_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129154617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE performance ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D79681C54C8C93 FOREIGN KEY (type_id) REFERENCES type_performance (id)');
        $this->addSql('CREATE INDEX IDX_82D79681C54C8C93 ON performance (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D79681C54C8C93');
        $this->addSql('DROP INDEX IDX_82D79681C54C8C93 ON performance');
        $this->addSql('ALTER TABLE performance DROP type_id');
    }
}

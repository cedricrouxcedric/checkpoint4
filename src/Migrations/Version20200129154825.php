<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129154825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wilder ADD performance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wilder ADD CONSTRAINT FK_AB682D53B91ADEEE FOREIGN KEY (performance_id) REFERENCES performance (id)');
        $this->addSql('CREATE INDEX IDX_AB682D53B91ADEEE ON wilder (performance_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wilder DROP FOREIGN KEY FK_AB682D53B91ADEEE');
        $this->addSql('DROP INDEX IDX_AB682D53B91ADEEE ON wilder');
        $this->addSql('ALTER TABLE wilder DROP performance_id');
    }
}

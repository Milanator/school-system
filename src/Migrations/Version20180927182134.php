<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180927182134 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_result ADD answer_id INT NOT NULL');
        $this->addSql('ALTER TABLE question_result ADD CONSTRAINT FK_1437EE1BAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('CREATE INDEX IDX_1437EE1BAA334807 ON question_result (answer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_result DROP FOREIGN KEY FK_1437EE1BAA334807');
        $this->addSql('DROP INDEX IDX_1437EE1BAA334807 ON question_result');
        $this->addSql('ALTER TABLE question_result DROP answer_id');
    }
}

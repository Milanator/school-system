<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180922165605 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exam_question DROP answer_id');
        $this->addSql('ALTER TABLE answer ADD exam_question_id INT NOT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A255345BBE FOREIGN KEY (exam_question_id) REFERENCES exam_question (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A255345BBE ON answer (exam_question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A255345BBE');
        $this->addSql('DROP INDEX IDX_DADD4A255345BBE ON answer');
        $this->addSql('ALTER TABLE answer DROP exam_question_id');
        $this->addSql('ALTER TABLE exam_question ADD answer_id INT NOT NULL');
    }
}

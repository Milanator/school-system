<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180923103442 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, count_answers INT NOT NULL, count_correct INT NOT NULL, INDEX IDX_B6F7494EA76ED395 (user_id), INDEX IDX_B6F7494E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, teacher TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, name VARCHAR(255) NOT NULL, correct TINYINT(1) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, category_id INT NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, done TINYINT(1) NOT NULL, count_answers INT NOT NULL, intented_for VARCHAR(10) NOT NULL, INDEX IDX_38BBA6C661220EA6 (creator_id), INDEX IDX_38BBA6C612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C661220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E12469DE2');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C612469DE2');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C661220EA6');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE exam');
    }
}

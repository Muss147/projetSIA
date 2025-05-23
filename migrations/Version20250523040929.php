<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523040929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE chef_chantier (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD chef_chantier_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396C22456F8F FOREIGN KEY (chef_chantier_id) REFERENCES chef_chantier (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7268396C22456F8F ON contrats (chef_chantier_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C22456F8F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chef_chantier
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7268396C22456F8F ON contrats
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP chef_chantier_id
        SQL);
    }
}

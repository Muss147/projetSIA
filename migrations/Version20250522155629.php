<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522155629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE contrats (id INT AUTO_INCREMENT NOT NULL, type_travaux_id INT NOT NULL, client_id INT NOT NULL, projet_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, taux_garantie VARCHAR(255) DEFAULT NULL, montant INT NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_7268396C899612C7 (type_travaux_id), INDEX IDX_7268396C19EB6921 (client_id), INDEX IDX_7268396CC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE projets (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, secteur_activite_id INT NOT NULL, business_unit_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, conducteur_travaux VARCHAR(255) DEFAULT NULL, tva TINYINT(1) DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_B454C1DB19EB6921 (client_id), INDEX IDX_B454C1DB5233A7FC (secteur_activite_id), INDEX IDX_B454C1DBA58ECB40 (business_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilitaires (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, valeur VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_86C64B7B727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396C899612C7 FOREIGN KEY (type_travaux_id) REFERENCES utilitaires (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396CC18272 FOREIGN KEY (projet_id) REFERENCES projets (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DB19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DB5233A7FC FOREIGN KEY (secteur_activite_id) REFERENCES utilitaires (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DBA58ECB40 FOREIGN KEY (business_unit_id) REFERENCES business_units (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires ADD CONSTRAINT FK_86C64B7B727ACA70 FOREIGN KEY (parent_id) REFERENCES utilitaires (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C899612C7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CC18272
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DB19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DB5233A7FC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DBA58ECB40
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires DROP FOREIGN KEY FK_86C64B7B727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contrats
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE projets
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilitaires
        SQL);
    }
}

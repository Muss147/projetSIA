<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526171559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, usine VARCHAR(255) DEFAULT NULL, ouvrage VARCHAR(255) DEFAULT NULL, type_travaux VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8B27C52B1823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE devis_bpu (id INT AUTO_INCREMENT NOT NULL, bpu_id INT NOT NULL, devis_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_B6D1B7BAC8CDA3B1 (bpu_id), INDEX IDX_B6D1B7BA41DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE factures_dqe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B1823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE devis_bpu ADD CONSTRAINT FK_B6D1B7BAC8CDA3B1 FOREIGN KEY (bpu_id) REFERENCES bpu (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE devis_bpu ADD CONSTRAINT FK_B6D1B7BA41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B1823061F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE devis_bpu DROP FOREIGN KEY FK_B6D1B7BAC8CDA3B1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE devis_bpu DROP FOREIGN KEY FK_B6D1B7BA41DEFADA
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE devis
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE devis_bpu
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE factures_dqe
        SQL);
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521030351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE parametres (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, updated_user_id INT DEFAULT NULL, deleted_user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_1A79799D727ACA70 (parent_id), INDEX IDX_1A79799DE104C1D3 (created_user_id), INDEX IDX_1A79799DBB649746 (updated_user_id), INDEX IDX_1A79799DFDE969F2 (deleted_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres ADD CONSTRAINT FK_1A79799D727ACA70 FOREIGN KEY (parent_id) REFERENCES parametres (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres ADD CONSTRAINT FK_1A79799DE104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres ADD CONSTRAINT FK_1A79799DBB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres ADD CONSTRAINT FK_1A79799DFDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD parametres_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A1944AEE5AE FOREIGN KEY (parametres_id) REFERENCES parametres (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BB423A1944AEE5AE ON bpu (parametres_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A1944AEE5AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres DROP FOREIGN KEY FK_1A79799D727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres DROP FOREIGN KEY FK_1A79799DE104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres DROP FOREIGN KEY FK_1A79799DBB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parametres DROP FOREIGN KEY FK_1A79799DFDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parametres
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BB423A1944AEE5AE ON bpu
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP parametres_id
        SQL);
    }
}

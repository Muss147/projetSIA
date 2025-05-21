<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521025909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE bpu (id INT AUTO_INCREMENT NOT NULL, created_user_id INT DEFAULT NULL, updated_user_id INT DEFAULT NULL, deleted_user_id INT DEFAULT NULL, unite VARCHAR(255) NOT NULL, materiaux INT DEFAULT NULL, main_doeuvre INT DEFAULT NULL, materiel INT DEFAULT NULL, debourse_sec INT DEFAULT NULL, frais_de_chantier INT DEFAULT NULL, frais_generaux INT DEFAULT NULL, marge_nette INT DEFAULT NULL, prix_unitaire_ht INT DEFAULT NULL, prix_unitaire VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_BB423A19E104C1D3 (created_user_id), INDEX IDX_BB423A19BB649746 (updated_user_id), INDEX IDX_BB423A19FDE969F2 (deleted_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A19E104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A19BB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A19FDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A19E104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A19BB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A19FDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bpu
        SQL);
    }
}

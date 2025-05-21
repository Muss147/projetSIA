<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521000136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE business_units (id INT AUTO_INCREMENT NOT NULL, created_user_id INT DEFAULT NULL, updated_user_id INT DEFAULT NULL, deleted_user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_975193F6E104C1D3 (created_user_id), INDEX IDX_975193F6BB649746 (updated_user_id), INDEX IDX_975193F6FDE969F2 (deleted_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE business_units_users (business_units_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_403B28039108727E (business_units_id), INDEX IDX_403B280367B3B43D (users_id), PRIMARY KEY(business_units_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units ADD CONSTRAINT FK_975193F6E104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units ADD CONSTRAINT FK_975193F6BB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units ADD CONSTRAINT FK_975193F6FDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units_users ADD CONSTRAINT FK_403B28039108727E FOREIGN KEY (business_units_id) REFERENCES business_units (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units_users ADD CONSTRAINT FK_403B280367B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units DROP FOREIGN KEY FK_975193F6E104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units DROP FOREIGN KEY FK_975193F6BB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units DROP FOREIGN KEY FK_975193F6FDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units_users DROP FOREIGN KEY FK_403B28039108727E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE business_units_users DROP FOREIGN KEY FK_403B280367B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE business_units
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE business_units_users
        SQL);
    }
}

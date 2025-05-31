<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250531170343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD created_user_id INT DEFAULT NULL, ADD updated_user_id INT DEFAULT NULL, ADD deleted_user_id INT DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD boite_postale VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD site_web VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E74E104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E74BB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E74FDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C82E74E104C1D3 ON clients (created_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C82E74BB649746 ON clients (updated_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C82E74FDE969F2 ON clients (deleted_user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E74E104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E74BB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E74FDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C82E74E104C1D3 ON clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C82E74BB649746 ON clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C82E74FDE969F2 ON clients
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP created_user_id, DROP updated_user_id, DROP deleted_user_id, DROP adresse, DROP boite_postale, DROP telephone, DROP email, DROP site_web, DROP created_at, DROP updated_at, DROP deleted_at
        SQL);
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522202228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD created_user_id INT DEFAULT NULL, ADD updated_user_id INT DEFAULT NULL, ADD deleted_user_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396CE104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396CBB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats ADD CONSTRAINT FK_7268396CFDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7268396CE104C1D3 ON contrats (created_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7268396CBB649746 ON contrats (updated_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7268396CFDE969F2 ON contrats (deleted_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD created_user_id INT DEFAULT NULL, ADD updated_user_id INT DEFAULT NULL, ADD deleted_user_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DBE104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DBBB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets ADD CONSTRAINT FK_B454C1DBFDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B454C1DBE104C1D3 ON projets (created_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B454C1DBBB649746 ON projets (updated_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B454C1DBFDE969F2 ON projets (deleted_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires ADD created_user_id INT DEFAULT NULL, ADD updated_user_id INT DEFAULT NULL, ADD deleted_user_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires ADD CONSTRAINT FK_86C64B7BE104C1D3 FOREIGN KEY (created_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires ADD CONSTRAINT FK_86C64B7BBB649746 FOREIGN KEY (updated_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires ADD CONSTRAINT FK_86C64B7BFDE969F2 FOREIGN KEY (deleted_user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_86C64B7BE104C1D3 ON utilitaires (created_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_86C64B7BBB649746 ON utilitaires (updated_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_86C64B7BFDE969F2 ON utilitaires (deleted_user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CE104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CBB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CFDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7268396CE104C1D3 ON contrats
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7268396CBB649746 ON contrats
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7268396CFDE969F2 ON contrats
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contrats DROP created_user_id, DROP updated_user_id, DROP deleted_user_id, DROP created_at, DROP updated_at, DROP deleted_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DBE104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DBBB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP FOREIGN KEY FK_B454C1DBFDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B454C1DBE104C1D3 ON projets
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B454C1DBBB649746 ON projets
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B454C1DBFDE969F2 ON projets
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projets DROP created_user_id, DROP updated_user_id, DROP deleted_user_id, DROP created_at, DROP updated_at, DROP deleted_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires DROP FOREIGN KEY FK_86C64B7BE104C1D3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires DROP FOREIGN KEY FK_86C64B7BBB649746
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires DROP FOREIGN KEY FK_86C64B7BFDE969F2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_86C64B7BE104C1D3 ON utilitaires
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_86C64B7BBB649746 ON utilitaires
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_86C64B7BFDE969F2 ON utilitaires
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilitaires DROP created_user_id, DROP updated_user_id, DROP deleted_user_id, DROP created_at, DROP updated_at, DROP deleted_at
        SQL);
    }
}

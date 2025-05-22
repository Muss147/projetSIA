<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521222051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A1944AEE5AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BB423A1944AEE5AE ON bpu
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD slug VARCHAR(255) NOT NULL, CHANGE parametres_id parametre_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A196358FF62 FOREIGN KEY (parametre_id) REFERENCES parametres (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BB423A196358FF62 ON bpu (parametre_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP FOREIGN KEY FK_BB423A196358FF62
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BB423A196358FF62 ON bpu
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu DROP slug, CHANGE parametre_id parametres_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bpu ADD CONSTRAINT FK_BB423A1944AEE5AE FOREIGN KEY (parametres_id) REFERENCES parametres (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BB423A1944AEE5AE ON bpu (parametres_id)
        SQL);
    }
}

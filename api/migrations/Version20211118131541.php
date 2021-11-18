<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118131541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE player ADD owner VARCHAR(255) NOT NULL DEFAULT 1');
        $this->addSql('ALTER INDEX idx_794381c62f43a116 RENAME TO IDX_794381C699E6F5DF');
        // add initial admin user
        $this->addSql('INSERT INTO "user" VALUES (1, \'' . $_ENV['USER_ADMIN_EMAIL'] . '\', \'["ROLE_ADMIN"]\', \'' . $_ENV['USER_ADMIN_PASSWORD'] . '\')');
        $this->addSql('INSERT INTO "user" VALUES (2, \'' . $_ENV['USER_EMAIL'] . '\', \'["ROLE_USER"]\', \'' . $_ENV['USER_PASSWORD'] . '\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE player DROP owner');
        $this->addSql('ALTER INDEX idx_794381c699e6f5df RENAME TO idx_794381c62f43a116');
    }
}

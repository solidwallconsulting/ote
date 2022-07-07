<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602125742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partners ADD CONSTRAINT FK_EFEB5164A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFEB5164A76ED395 ON partners (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners DROP FOREIGN KEY FK_EFEB5164A76ED395');
        $this->addSql('DROP INDEX UNIQ_EFEB5164A76ED395 ON partners');
        $this->addSql('ALTER TABLE partners DROP user_id');
    }
}

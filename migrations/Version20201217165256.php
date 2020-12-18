<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217165256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9BA0E79C3');
        $this->addSql('DROP INDEX UNIQ_8A8E26E9BA0E79C3 ON conversation');
        $this->addSql('DROP INDEX last_message_id ON conversation');
        $this->addSql('ALTER TABLE conversation DROP last_message_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FFB88E14F');
        $this->addSql('DROP INDEX created_at_index ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FFB88E14F ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F9AC0396 ON message');
        $this->addSql('ALTER TABLE message ADD conversation_id_id INT DEFAULT NULL, ADD utilisateur_id_id INT DEFAULT NULL, DROP utilisateur_id, DROP conversation_id, CHANGE content content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F6B92BD7B FOREIGN KEY (conversation_id_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F6B92BD7B ON message (conversation_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FB981C689 ON message (utilisateur_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD last_message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A8E26E9BA0E79C3 ON conversation (last_message_id)');
        $this->addSql('CREATE INDEX last_message_id ON conversation (last_message_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F6B92BD7B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB981C689');
        $this->addSql('DROP INDEX IDX_B6BD307F6B92BD7B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FB981C689 ON message');
        $this->addSql('ALTER TABLE message ADD utilisateur_id INT DEFAULT NULL, ADD conversation_id INT DEFAULT NULL, DROP conversation_id_id, DROP utilisateur_id_id, CHANGE content content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX created_at_index ON message (created_at)');
        $this->addSql('CREATE INDEX IDX_B6BD307FFB88E14F ON message (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
    }
}

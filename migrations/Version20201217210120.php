<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217210120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD last_message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8A8E26E9BA0E79C3 ON conversation (last_message_id)');
        $this->addSql('CREATE INDEX last_message_id_index ON conversation (last_message_id)');
        $this->addSql('ALTER TABLE enqueteur CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE date_naissance date_naissance DATE NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE tel tel INT NOT NULL, CHANGE mot_de_passe mot_de_passe VARCHAR(255) NOT NULL, CHANGE matricule_fiscale matricule_fiscale VARCHAR(255) NOT NULL, CHANGE registre_des_commeerces registre_des_commeerces LONGBLOB NOT NULL, CHANGE adresse_societe adresse_societe VARCHAR(255) NOT NULL, CHANGE logo logo LONGBLOB NOT NULL, CHANGE genre genre TINYINT(1) NOT NULL, CHANGE cin cin INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9BA0E79C3');
        $this->addSql('DROP INDEX UNIQ_8A8E26E9BA0E79C3 ON conversation');
        $this->addSql('DROP INDEX last_message_id_index ON conversation');
        $this->addSql('ALTER TABLE conversation DROP last_message_id');
        $this->addSql('ALTER TABLE enqueteur CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_naissance date_naissance DATE DEFAULT NULL, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tel tel INT DEFAULT NULL, CHANGE mot_de_passe mot_de_passe VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE matricule_fiscale matricule_fiscale VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE registre_des_commeerces registre_des_commeerces LONGBLOB DEFAULT NULL, CHANGE adresse_societe adresse_societe VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE logo logo LONGBLOB DEFAULT NULL, CHANGE genre genre TINYINT(1) DEFAULT NULL, CHANGE cin cin INT DEFAULT NULL');
    }
}

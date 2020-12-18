<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218000105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choix_reponse (id INT AUTO_INCREMENT NOT NULL, question_choix_multiples_id INT NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_796A26BE2D5F2B0 (question_choix_multiples_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, last_message_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8A8E26E9BA0E79C3 (last_message_id), INDEX last_message_id_index (last_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enqueteur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, conversation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, matricule_fiscale VARCHAR(255) NOT NULL, registre_des_commeerces LONGBLOB NOT NULL, adresse_societe VARCHAR(255) NOT NULL, logo LONGBLOB NOT NULL, genre TINYINT(1) NOT NULL, cin INT NOT NULL, INDEX IDX_33BC7EBFFB88E14F (utilisateur_id), INDEX IDX_33BC7EBF9AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, conversation_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FFB88E14F (utilisateur_id), INDEX IDX_B6BD307F9AC0396 (conversation_id), INDEX created_at_index (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nouveau_type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, offre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, contenue VARCHAR(255) DEFAULT NULL, INDEX IDX_5A8600B01E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, sondage_id INT NOT NULL, texte VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494EBAF4AE56 (sondage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_choix_multiples (id INT AUTO_INCREMENT NOT NULL, sondage_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_9574480FBAF4AE56 (sondage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remise (id INT AUTO_INCREMENT NOT NULL, pourcentage DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_logique_id INT DEFAULT NULL, question_multi_choix_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_5FB6DEC76CEB5729 (question_logique_id), INDEX IDX_5FB6DEC7FAEBE406 (question_multi_choix_id), INDEX IDX_5FB6DEC7FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondage (id INT AUTO_INCREMENT NOT NULL, enqueteur_id INT NOT NULL, sujet_id INT NOT NULL, titre VARCHAR(255) DEFAULT NULL, nb_participant INT DEFAULT NULL, nb_question INT DEFAULT NULL, nb_reponse INT DEFAULT NULL, INDEX IDX_7579C89FDB28D7F1 (enqueteur_id), INDEX IDX_7579C89F7C4D497E (sujet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(255) NOT NULL, tel INT DEFAULT NULL, genre TINYINT(1) DEFAULT NULL, mot_de_passe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cin INT NOT NULL, photo LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choix_reponse ADD CONSTRAINT FK_796A26BE2D5F2B0 FOREIGN KEY (question_choix_multiples_id) REFERENCES question_choix_multiples (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE enqueteur ADD CONSTRAINT FK_33BC7EBFFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE enqueteur ADD CONSTRAINT FK_33BC7EBF9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B01E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondage (id)');
        $this->addSql('ALTER TABLE question_choix_multiples ADD CONSTRAINT FK_9574480FBAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondage (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC76CEB5729 FOREIGN KEY (question_logique_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FAEBE406 FOREIGN KEY (question_multi_choix_id) REFERENCES question_choix_multiples (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE sondage ADD CONSTRAINT FK_7579C89FDB28D7F1 FOREIGN KEY (enqueteur_id) REFERENCES enqueteur (id)');
        $this->addSql('ALTER TABLE sondage ADD CONSTRAINT FK_7579C89F7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enqueteur DROP FOREIGN KEY FK_33BC7EBF9AC0396');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FFB88E14F');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE sondage DROP FOREIGN KEY FK_7579C89FDB28D7F1');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9BA0E79C3');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B01E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC76CEB5729');
        $this->addSql('ALTER TABLE choix_reponse DROP FOREIGN KEY FK_796A26BE2D5F2B0');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FAEBE406');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBAF4AE56');
        $this->addSql('ALTER TABLE question_choix_multiples DROP FOREIGN KEY FK_9574480FBAF4AE56');
        $this->addSql('ALTER TABLE sondage DROP FOREIGN KEY FK_7579C89F7C4D497E');
        $this->addSql('ALTER TABLE enqueteur DROP FOREIGN KEY FK_33BC7EBFFB88E14F');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FB88E14F');
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE choix_reponse');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE enqueteur');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE nouveau_type');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_choix_multiples');
        $this->addSql('DROP TABLE remise');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('DROP TABLE utilisateur');
    }
}

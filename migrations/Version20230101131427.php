<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101131427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abus (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT NOT NULL, internaute_id INT NOT NULL, description LONGTEXT DEFAULT NULL, date_encodage DATE NOT NULL, INDEX IDX_72C9FD01BA9CD190 (commentaire_id), INDEX IDX_72C9FD01CAF41882 (internaute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc_internaute (bloc_id INT NOT NULL, internaute_id INT NOT NULL, INDEX IDX_894E8E5A5582E9C0 (bloc_id), INDEX IDX_894E8E5ACAF41882 (internaute_id), PRIMARY KEY(bloc_id, internaute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, validation TINYINT(1) NOT NULL, mis_en_avant TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_prestataire (categorie_id INT NOT NULL, prestataire_id INT NOT NULL, INDEX IDX_BF5C4289BCF5E72D (categorie_id), INDEX IDX_BF5C4289BE3DB2B7 (prestataire_id), PRIMARY KEY(categorie_id, prestataire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_postal (id INT AUTO_INCREMENT NOT NULL, cp VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT NOT NULL, internaute_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, cote INT DEFAULT NULL, date_encodage DATE NOT NULL, INDEX IDX_67F068BCBE3DB2B7 (prestataire_id), INDEX IDX_67F068BCCAF41882 (internaute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, cp_id INT DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, INDEX IDX_E2E2D1EEEA8F463E (cp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, internaute_id INT DEFAULT NULL, prestataire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C53D045FBCF5E72D (categorie_id), UNIQUE INDEX UNIQ_C53D045FCAF41882 (internaute_id), INDEX IDX_C53D045FBE3DB2B7 (prestataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internaute (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, newsletter TINYINT(1) NOT NULL, bloque TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internaute_prestataire (internaute_id INT NOT NULL, prestataire_id INT NOT NULL, INDEX IDX_D906EC3ACAF41882 (internaute_id), INDEX IDX_D906EC3ABE3DB2B7 (prestataire_id), PRIMARY KEY(internaute_id, prestataire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localite (id INT AUTO_INCREMENT NOT NULL, commune_id INT DEFAULT NULL, cp_id INT DEFAULT NULL, localite VARCHAR(255) DEFAULT NULL, INDEX IDX_F5D7E4A9131A4F72 (commune_id), INDEX IDX_F5D7E4A9EA8F463E (cp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestataire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, siteweb VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, numero_tva VARCHAR(255) DEFAULT NULL, bloque TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C11D7DD1BE3DB2B7 (prestataire_id), INDEX IDX_C11D7DD1BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, tarif DOUBLE PRECISION NOT NULL, infos_complementaires LONGTEXT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, debut_affichage DATE NOT NULL, fin_affichage DATE NOT NULL, date_creation DATE NOT NULL, INDEX IDX_C27C9369BE3DB2B7 (prestataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, prestataire_id INT DEFAULT NULL, internaute_id INT DEFAULT NULL, commune_id INT DEFAULT NULL, localite_id INT DEFAULT NULL, cp_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse_no VARCHAR(255) DEFAULT NULL, adresse_rue VARCHAR(255) DEFAULT NULL, date_inscription DATE NOT NULL, visible TINYINT(1) NOT NULL, inscript_conf TINYINT(1) NOT NULL, nbre_essai INT DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), UNIQUE INDEX UNIQ_1D1C63B3BE3DB2B7 (prestataire_id), UNIQUE INDEX UNIQ_1D1C63B3CAF41882 (internaute_id), INDEX IDX_1D1C63B3131A4F72 (commune_id), INDEX IDX_1D1C63B3924DD2B5 (localite_id), INDEX IDX_1D1C63B3EA8F463E (cp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abus ADD CONSTRAINT FK_72C9FD01BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE abus ADD CONSTRAINT FK_72C9FD01CAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE bloc_internaute ADD CONSTRAINT FK_894E8E5A5582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bloc_internaute ADD CONSTRAINT FK_894E8E5ACAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_prestataire ADD CONSTRAINT FK_BF5C4289BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_prestataire ADD CONSTRAINT FK_BF5C4289BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCCAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEEA8F463E FOREIGN KEY (cp_id) REFERENCES code_postal (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FCAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE internaute_prestataire ADD CONSTRAINT FK_D906EC3ACAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE internaute_prestataire ADD CONSTRAINT FK_D906EC3ABE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE localite ADD CONSTRAINT FK_F5D7E4A9131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE localite ADD CONSTRAINT FK_F5D7E4A9EA8F463E FOREIGN KEY (cp_id) REFERENCES code_postal (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CAF41882 FOREIGN KEY (internaute_id) REFERENCES internaute (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3924DD2B5 FOREIGN KEY (localite_id) REFERENCES localite (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3EA8F463E FOREIGN KEY (cp_id) REFERENCES code_postal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc_internaute DROP FOREIGN KEY FK_894E8E5A5582E9C0');
        $this->addSql('ALTER TABLE categorie_prestataire DROP FOREIGN KEY FK_BF5C4289BCF5E72D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBCF5E72D');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1BCF5E72D');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEEA8F463E');
        $this->addSql('ALTER TABLE localite DROP FOREIGN KEY FK_F5D7E4A9EA8F463E');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3EA8F463E');
        $this->addSql('ALTER TABLE abus DROP FOREIGN KEY FK_72C9FD01BA9CD190');
        $this->addSql('ALTER TABLE localite DROP FOREIGN KEY FK_F5D7E4A9131A4F72');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3131A4F72');
        $this->addSql('ALTER TABLE abus DROP FOREIGN KEY FK_72C9FD01CAF41882');
        $this->addSql('ALTER TABLE bloc_internaute DROP FOREIGN KEY FK_894E8E5ACAF41882');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCCAF41882');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FCAF41882');
        $this->addSql('ALTER TABLE internaute_prestataire DROP FOREIGN KEY FK_D906EC3ACAF41882');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CAF41882');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3924DD2B5');
        $this->addSql('ALTER TABLE categorie_prestataire DROP FOREIGN KEY FK_BF5C4289BE3DB2B7');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCBE3DB2B7');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBE3DB2B7');
        $this->addSql('ALTER TABLE internaute_prestataire DROP FOREIGN KEY FK_D906EC3ABE3DB2B7');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1BE3DB2B7');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369BE3DB2B7');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BE3DB2B7');
        $this->addSql('DROP TABLE abus');
        $this->addSql('DROP TABLE bloc');
        $this->addSql('DROP TABLE bloc_internaute');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_prestataire');
        $this->addSql('DROP TABLE code_postal');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE internaute');
        $this->addSql('DROP TABLE internaute_prestataire');
        $this->addSql('DROP TABLE localite');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE prestataire');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

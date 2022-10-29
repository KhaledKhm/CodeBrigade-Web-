<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301230722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(40) DEFAULT NULL, password VARCHAR(128) DEFAULT NULL, role VARCHAR(16) DEFAULT NULL, account_status VARCHAR(16) DEFAULT NULL, cin_personne INT DEFAULT NULL, immatricule_entreprise VARCHAR(16) DEFAULT NULL, nom_personne VARCHAR(16) DEFAULT NULL, prenom_personne VARCHAR(16) DEFAULT NULL, libelle_entreprise VARCHAR(16) DEFAULT NULL, sexe_personne VARCHAR(10) DEFAULT NULL, date_nais_personne DATE DEFAULT NULL, etat_sociale_personne VARCHAR(16) DEFAULT NULL, telephone INT DEFAULT NULL, adresse VARCHAR(128) DEFAULT NULL, email VARCHAR(64) DEFAULT NULL, siteweb VARCHAR(64) DEFAULT NULL, domaine_personne VARCHAR(64) DEFAULT NULL, secteur_entreprise VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331195717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_utilisateur (offre_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_5635E9934CC8505A (offre_id), INDEX IDX_5635E993FB88E14F (utilisateur_id), PRIMARY KEY(offre_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Utilisateur_favoris (offre_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_D5BC45B44CC8505A (offre_id), INDEX IDX_D5BC45B4FB88E14F (utilisateur_id), PRIMARY KEY(offre_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_utilisateur ADD CONSTRAINT FK_5635E9934CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_utilisateur ADD CONSTRAINT FK_5635E993FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Utilisateur_favoris ADD CONSTRAINT FK_D5BC45B44CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Utilisateur_favoris ADD CONSTRAINT FK_D5BC45B4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offre_utilisateur');
        $this->addSql('DROP TABLE Utilisateur_favoris');
    }
}

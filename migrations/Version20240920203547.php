<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240920203547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recepie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, is_favorite TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recepie_ingredient (recepie_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_FD4708168AD03ECC (recepie_id), INDEX IDX_FD470816933FE08C (ingredient_id), PRIMARY KEY(recepie_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recepie_ingredient ADD CONSTRAINT FK_FD4708168AD03ECC FOREIGN KEY (recepie_id) REFERENCES recepie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recepie_ingredient ADD CONSTRAINT FK_FD470816933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recepie_ingredient DROP FOREIGN KEY FK_FD4708168AD03ECC');
        $this->addSql('ALTER TABLE recepie_ingredient DROP FOREIGN KEY FK_FD470816933FE08C');
        $this->addSql('DROP TABLE recepie');
        $this->addSql('DROP TABLE recepie_ingredient');
    }
}

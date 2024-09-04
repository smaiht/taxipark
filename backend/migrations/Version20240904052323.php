<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904052323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_change_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car_change_log (id INT NOT NULL, old_car_id INT DEFAULT NULL, new_car_id INT DEFAULT NULL, driver_id INT NOT NULL, change_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6CC584C98A092518 ON car_change_log (old_car_id)');
        $this->addSql('CREATE INDEX IDX_6CC584C93B5CCEB5 ON car_change_log (new_car_id)');
        $this->addSql('CREATE INDEX IDX_6CC584C9C3423909 ON car_change_log (driver_id)');
        $this->addSql('ALTER TABLE car_change_log ADD CONSTRAINT FK_6CC584C98A092518 FOREIGN KEY (old_car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_change_log ADD CONSTRAINT FK_6CC584C93B5CCEB5 FOREIGN KEY (new_car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_change_log ADD CONSTRAINT FK_6CC584C9C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_change_log_id_seq CASCADE');
        $this->addSql('ALTER TABLE car_change_log DROP CONSTRAINT FK_6CC584C98A092518');
        $this->addSql('ALTER TABLE car_change_log DROP CONSTRAINT FK_6CC584C93B5CCEB5');
        $this->addSql('ALTER TABLE car_change_log DROP CONSTRAINT FK_6CC584C9C3423909');
        $this->addSql('DROP TABLE car_change_log');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190228105503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE prioridad (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY fk_incidencia_comentario');
        $this->addSql('DROP INDEX fk_incidencia_comentario ON comentario');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY fk_categoria_incidencia');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY fk_cliente_incidencia');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY fk_tecnico_incidencia');
        $this->addSql('DROP INDEX fk_cliente_incidencia ON incidencia');
        $this->addSql('DROP INDEX fk_categoria_incidencia ON incidencia');
        $this->addSql('DROP INDEX fk_tecnico_incidencia ON incidencia');
        $this->addSql('ALTER TABLE incidencia CHANGE tecnico tecnico INT NOT NULL, CHANGE fecha_hora fecha_hora DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE prioridad');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT fk_incidencia_comentario FOREIGN KEY (incidencia) REFERENCES incidencia (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_incidencia_comentario ON comentario (incidencia)');
        $this->addSql('ALTER TABLE incidencia CHANGE fecha_hora fecha_hora DATETIME NOT NULL, CHANGE tecnico tecnico INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT fk_categoria_incidencia FOREIGN KEY (categoria) REFERENCES categoria (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT fk_cliente_incidencia FOREIGN KEY (cliente) REFERENCES cliente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT fk_tecnico_incidencia FOREIGN KEY (tecnico) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_cliente_incidencia ON incidencia (cliente)');
        $this->addSql('CREATE INDEX fk_categoria_incidencia ON incidencia (categoria)');
        $this->addSql('CREATE INDEX fk_tecnico_incidencia ON incidencia (tecnico)');
    }
}

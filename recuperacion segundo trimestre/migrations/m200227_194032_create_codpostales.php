<?php

use yii\db\Migration;

/**
 * Class m200227_194032_create_codpostales.
 */
class m200227_194032_create_codpostales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('poblaciones', [
            'id' => $this->bigPrimaryKey(),
            'nombre' => $this->string()->notNull(),
            'provincia_id' => $this->bigInteger(),
        ]);

        $this->createTable('provincias', [
            'id' => $this->bigPrimaryKey(),
            'nombre' => $this->string()->notNull(),
        ]);

        $this->createTable('codpostales', [
            'id' => $this->decimal(5),
            'poblacion_id' => $this->bigInteger(),
        ]);

        $this->addPrimaryKey('pk_codpostales', 'codpostales', 'id');

        $this->addForeignKey(
            'fk_codpostales_poblaciones',
            'codpostales',
            'poblacion_id',
            'poblaciones',
            'id'
        );

        $this->addForeignKey(
            'fk_poblaciones_provincias',
            'poblaciones',
            'provincia_id',
            'provincias',
            'id'
        );

        $this->renameColumn('lectores', 'cod_postal', 'codpostal_id');

        $this->execute('INSERT INTO codpostales (id)
                        SELECT DISTINCT codpostal_id FROM lectores');

        $this->addForeignKey(
            'fk_lectores_codpostales',
            'lectores',
            'codpostal_id',
            'codpostales',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_lectores_codpostales', 'lectores');
        $this->dropForeignKey('fk_poblaciones_provincias', 'poblaciones');
        $this->dropForeignKey('fk_codpostales_poblaciones', 'codpostales');
        $this->dropTable('codpostales');
        $this->dropTable('poblaciones');
        $this->dropTable('provincias');
        $this->renameColumn('lectores', 'codpostal_id', 'cod_postal');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200227_194032_create_codpostales cannot be reverted.\n";

        return false;
    }
    */
}

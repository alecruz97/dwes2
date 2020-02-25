<?php

use yii\db\Migration;

/**
 * Class m200225_164200_tablas
 */
class m200225_164200_tablas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('poblaciones', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull()->unique(),
            'provincia_id' => $this->bigInteger()->notNull(),
        ]);

        $this->createTable('codpostales', [
            'id' => $this->primaryKey(),
            'codpostal' => $this->integer(5),
            'poblacion_id' => $this->bigInteger()->notNull(),
        ]);

        $this->createTable('provincias', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull()->unique(),
        ]);

        $this->addForeignKey(
            'fk_poblaciones_provincias',
            'poblaciones',
            'provincia_id',
            'provincias',
            'id'
        );

        $this->addForeignKey(
            'fk_codpostales_poblaciones',
            'codpostales',
            'poblacion_id',
            'poblaciones',
            'id'
        );

        $this->addForeignKey(
            'fk_lectores_codpostales',
            'lectores',
            'codpostal_id',
            'codpostales',
            'id'
        );

        $this->insert('provincias', [
            'nombre' => 'Cádiz'
        ]);

        $this->insert('poblaciones', [
            'nombre' => 'Sanlúcar',
            'provincia_id' => 1
        ]);

        $this->insert('codpostales', [
            'codpostal' => 11540,
            'poblacion_id' => 1,
        ]);

        $this->insert('lectores', [
            'numero' => 111,
            'nombre' => 'pepe',
            'direccion' => 'C/. Ancha',
            'codpostal_id' => 1,
            'fecha_nac' => "1978-06-02"
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_codpostales_poblaciones', 'codpostales');
        $this->dropTable('codpostales');

        $this->dropForeignKey('fk_poblaciones_provincias', 'poblaciones');
        $this->dropTable('poblaciones');

        $this->dropTable('provincias');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200225_164132_tablas cannot be reverted.\n";

        return false;
    }
    */
}

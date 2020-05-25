<?php

use yii\db\Migration;

/**
 * Class m200303_162351_add_column_lectorid_usuarios
 */
class m200303_162351_add_column_lectorid_usuarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'lector_id', $this->bigInteger());

        $this->addForeignKey(
            'fk_usuarios_lectores',
            'usuarios',
            'lector_id',
            'lectores',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_usuarios_lectores', 'usuarios');
        $this->dropColumn('usuarios', 'lector_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200303_162351_add_column_lectorid_usuarios cannot be reverted.\n";

        return false;
    }
    */
}

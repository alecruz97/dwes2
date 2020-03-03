<?php

use yii\db\Migration;

/**
 * Class m200303_170155_libros_favoritos
 */
class m200303_170155_libros_favoritos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favoritos', [
            'libro_id' => $this->bigInteger(),
            'lector_id' => $this->bigInteger(),
        ]);

        $this->addForeignKey(
            'fk_favoritos_lectores',
            'favoritos',
            'lector_id',
            'lectores',
            'id'
        );

        $this->addForeignKey(
            'fk_favoritos_libros',
            'favoritos',
            'libro_id',
            'libros',
            'id'
        );

        $this->insert('favoritos', [
            'libro_id' => 1,
            'lector_id' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_favoritos_lectores', 'favoritos');
        $this->dropForeignKey('fk_favoritos_libros', 'favoritos');
        $this->dropTable('favoritos');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200303_170155_libros_favoritos cannot be reverted.\n";

        return false;
    }
    */
}

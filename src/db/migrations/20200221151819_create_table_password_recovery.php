<?php

use Phinx\Migration\AbstractMigration;

class CreateTablePasswordRecovery extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table("password_recovery");
        $table->addColumn("email","string",["limit" => 255]);
        $table->addColumn("hash","string",["limit" => 88]);
        $table->addColumn('status', 'integer', ['null' => true]);
        $table->addColumn('user_id', 'integer', ['null' => true]);
        $table->addForeignKey('user_id', 'users', 'id',['delete'=> 'SET_NULL']);
        $table->addColumn("created",'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->create();
    }
}

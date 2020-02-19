<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
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
        $table = $this->table("users");
        $table->addColumn("name","string",["limit" => 255]);
        $table->addColumn("password","string",["limit" => 60]);
        $table->addColumn("email","string",["limit" => 70]);
        $table->addColumn("phone","string",["limit" => 11]);
        $table->addColumn("avatar","string",["limit" => 300]);
        $table->addColumn('role_id', 'integer', ['null' => false]);
        $table->addForeignKey('role_id', 'roles', 'id');
        $table->addColumn("created",'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->create();
    }
}

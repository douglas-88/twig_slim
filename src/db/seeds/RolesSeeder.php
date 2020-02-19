<?php


use Phinx\Seed\AbstractSeed;

class RolesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'     => 'admin',
                'description' => "Administrador do Sistema",
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $roles = $this->table('roles');
        $roles->insert($data)->saveData();
    }
}

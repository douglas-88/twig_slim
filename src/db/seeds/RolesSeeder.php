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
        /**
         *   1 => "/painel/admin",
        2 => "/painel/professor",
        3 => "/painel/cliente"
         */
        $data = [
            [
                'name'     => 'admin',
                'description' => "Administrador do Sistema",
                'uri' => "/painel/admin",
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'name'     => 'professor',
                'description' => "Administra os Cursos dele",
                'uri' => "/painel/professor",
                'created'  => date('Y-m-d H:i:s')
            ],
            [
                'name'     => 'cliente',
                'description' => "Acessa seus dados e cursos matriculados",
                'uri' => "/painel/cliente",
                'created'  => date('Y-m-d H:i:s')
            ],
        ];

        $roles = $this->table('roles');
        $roles->insert($data)->saveData();
    }
}

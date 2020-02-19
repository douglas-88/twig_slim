<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'email'    => 'admin@gmail.com',
                'password' => '$2y$12$o0vmN5EMkgjEiBxtRot3T.JN.Yvhu1TxYpI3qfG0Xl4QvxImE0.ZC',
                'phone'    => '21993725886',
                'avatar'   => '',
                'role_id'  => 1,
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}

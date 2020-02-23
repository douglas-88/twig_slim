<?php


namespace Core;

use App\traits\View;
use Slim\Container;

class Controller
{

    protected $db;
    public function __construct(Container $c)
    {
         $this->db = $c->db;
    }

    use View;

}
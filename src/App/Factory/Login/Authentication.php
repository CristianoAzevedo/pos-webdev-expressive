<?php

namespace App\Factory\Login;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use App\Action\Login\Authentication as Action;

class Authentication
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('App\Factory\Db\Adapter\Adapter');
        $tableGateway = new TableGateway('login', $adapter);

        return new Action($tableGateway);
    }
}

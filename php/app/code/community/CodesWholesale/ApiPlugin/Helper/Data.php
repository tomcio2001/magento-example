<?php

use CodesWholesaleFramework\Connection\Connection;

class CodesWholesale_ApiPlugin_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function connectToCw()
    {
        if(Connection::hasConnection()) {
            return Connection::getConnection(array());
        }

        $config  = Mage::getConfig()->getResourceConnectionConfig("default_setup")->asArray();

        $pdo = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);

        $options = array(
            'environment'   => Mage::getStoreConfig('apiplugin_connection/apiplugin_group/apiplugin_env'),
            'client_id'     => Mage::getStoreConfig('apiplugin_connection/apiplugin_group/apiplugin_client_id'),
            'client_secret' => Mage::getStoreConfig('apiplugin_connection/apiplugin_group/apiplugin_client_secret'),
            'client_headers' => 'CodesWholesale-Magento/2.0',
            'db' => $pdo
        );

        return Connection::getConnection($options);
    }
}
	 
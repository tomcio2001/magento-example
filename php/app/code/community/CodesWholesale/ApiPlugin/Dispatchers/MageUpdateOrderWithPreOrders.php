<?php

class CodesWholesale_ApiPlugin_Dispatchers_MageUpdateOrderWithPreOrders
{
    public function update($params, $commentText)
    {
        Mage::helper('apiplugin/CwUpdatePreOrder')->updateLinks($params[0]['item']['order_id'], json_encode(array_merge($params[0]['linksToAdd'], array_values($params[0]['links']))));
        Mage::helper('apiplugin/CwUpdatePreOrder')->updatePreOrder($params[0]['item']['order_id'], $params[0]['preOrdersLeft']);

        $keys[] = array(
            'item' => $params[0]['item'],
            'codes' => $params[0]['codes']
        );

        $order = Mage::getSingleton('sales/order')->loadByAttribute('entity_id', $params[0]['item']['order_id']);

        $mail = new \CodesWholesale_ApiPlugin_Mails_MageSendPreOrderMail();
        $mail->sendPreOrderMail($order, $params[0]['attachments'], $keys, $params[0]['preOrdersLeft']);

        $order->addStatusHistoryComment($commentText);
        $order->save();
    }
}
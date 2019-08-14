<?php
require_once 'xmlrpc/xmlrpc.inc';

/**
 * Gateway to Print Science personalization API
 *
 */
class PrintScience_Personalization_Model_ApiGateway
{
    /**
     * Calls beginPersonalization API function and returns response.
     *
     * @param int $templateId
     * @param string $successUrl
     * @param string $failUrl
     * @param string $cancelUrl
     * @return PrintScience_Personalization_Model_ApiGateway_Response_Begin
     */
    public function beginPersonalization($templateId, $successUrl, $failUrl, $cancelUrl)
    {
        $client = new xmlrpc_client(Mage::getStoreConfig('catalog/personalization/api_url'));

        $function = new xmlrpcmsg('beginPersonalization', array(
            php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
            php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
            php_xmlrpc_encode($templateId),
            php_xmlrpc_encode($successUrl),
            php_xmlrpc_encode($failUrl),
            php_xmlrpc_encode($cancelUrl),
            php_xmlrpc_encode('')
        ));

        $response = $client->send($function);

        return new PrintScience_Personalization_Model_ApiGateway_Response_Begin($response);
    }

    /**
     * Calls getPreview API function and returns response.
     *
     * @param string $sessionKey
     * @return PrintScience_Personalization_Model_ApiGateway_Response_GetPreview
     */
    public function getPreview($sessionKey)
    {
        $client = new xmlrpc_client(Mage::getStoreConfig('catalog/personalization/api_url'));

        $function = new xmlrpcmsg('getPreview', array(
        php_xmlrpc_encode($sessionKey)
        ));

        $response = $client->send($function);

        return new PrintScience_Personalization_Model_ApiGateway_Response_GetPreview($response);
    }

    /**
     * Calls endPersonalization API function.
     *
     * @param string $sessionKey
     */
    public function endPersonalization($sessionKey)
    {
        $client = new xmlrpc_client(Mage::getStoreConfig('catalog/personalization/api_url'));

        $function = new xmlrpcmsg('endPersonalization', array(
        php_xmlrpc_encode($sessionKey)
        ));

        $client->send($function);
    }

/**
     * Calls resumePersonalization API function and returns response.
     *
     * @param int $templateId
     * @param string $successUrl
     * @param string $failUrl
     * @param string $cancelUrl
     * @return PrintScience_Personalization_Model_ApiGateway_Response_Begin
     */
    public function resumePersonalization($sessionKey, $templateId, $successUrl, $failUrl, $cancelUrl)
    {
        $client = new xmlrpc_client(Mage::getStoreConfig('catalog/personalization/api_url'));

        $function = new xmlrpcmsg('resumePersonalization', array(
            php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
            php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
            php_xmlrpc_encode($sessionKey),
            php_xmlrpc_encode($templateId),
            php_xmlrpc_encode($successUrl),
            php_xmlrpc_encode($failUrl),
            php_xmlrpc_encode($cancelUrl),
            php_xmlrpc_encode('')
        ));

        $response = $client->send($function);

        return new PrintScience_Personalization_Model_ApiGateway_Response_Begin($response);
    }    
}
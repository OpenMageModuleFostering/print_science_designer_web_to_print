<?php
require_once 'xmlrpc/xmlrpc.inc';
/**
 * Test the connection
 *
 */
class PrintScience_Personalization_TestController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
		$success = true;
		try {
			$_helper = Mage::helper('printscience_personalization/data');
			
			$apiUrl = Mage::getStoreConfig('catalog/personalization/api_url');
			$apiVersion = Mage::getStoreConfig('catalog/personalization/api_version');
			$magelocale = Mage::app()->getLocale()->getLocaleCode();
			$localeParts = explode('_',$magelocale);
			$locale=$localeParts[0];
			$client = new xmlrpc_client($apiUrl);
			$function = null;
			switch($apiVersion)
			{
				case '1.0.0':
					$function = new xmlrpcmsg('beginPersonalization', array(
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode('')
					));
					break;
				case '2.0.0':
					$function = new xmlrpcmsg('beginPersonalization', array(
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode('en'),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode('')
					));
					break;
				case '4.0.0':
				   $function = new xmlrpcmsg('beginPersonalization', array(
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode($locale)
					));
					break;
				default:
					$function = new xmlrpcmsg('beginPersonalization', array(
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
						php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode(''),
						php_xmlrpc_encode('')
					));
					break;
			}
			$response = $client->send($function);
			$APIErrorCode = $response->errno;
			/********************** CHECK FOR API CONNECTION *************/
			
			if ($APIErrorCode == '3' || $APIErrorCode == '1') {
				$success = false;
			}
		} catch (Exception $e) {

            $success = false;
        }
		
        if ($success) {
            $msg = $msg . $_helper->__("Your API credentials are working fine.");
            Mage::getSingleton('adminhtml/session')->addSuccess($msg);
        } else {
            $msg = $msg . $_helper->__("Your API credentials are wrong, please check and try again.");
            Mage::getSingleton('adminhtml/session')->addError($msg);
        }
		$this->_redirectReferer();
    }

}


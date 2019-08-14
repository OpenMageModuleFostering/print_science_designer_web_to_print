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
	 
    public function beginPersonalization($productId, $templateId, $successUrl, $failUrl, $cancelUrl)
    {
        $apiUrl = Mage::getStoreConfig('catalog/personalization/api_url');
        $apiVersion = Mage::getStoreConfig('catalog/personalization/api_version');
		$magelocale = Mage::app()->getLocale()->getLocaleCode();
		$localeParts = explode('_',$magelocale);
		$locale=$localeParts[0];
        $client = new xmlrpc_client($apiUrl);
        $function = null;
		if($templateId!='') {
			$templateXml = php_xmlrpc_encode($templateId);
		}
        // check api version
        switch($apiVersion)
        {
            case '1.0.0':
                $function = new xmlrpcmsg('beginPersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode('')
                ));
                break;
            case '2.0.0':
                $function = new xmlrpcmsg('beginPersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
                    php_xmlrpc_encode('en'),
                    php_xmlrpc_encode(''),
                    php_xmlrpc_encode(''),
					$templateXml
                ));
                break;
            case '4.0.0':
               $function = new xmlrpcmsg('beginPersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
					php_xmlrpc_encode($locale),
					$templateXml
                ));
                break;
            default:
                $function = new xmlrpcmsg('beginPersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($templateId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
					$templateXml
                ));
                break;
        }
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

        $function = new xmlrpcmsg('getPreviewMulti', array(
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
     * Calls endPersonalization API function.
     *
     * @param string $sessionKey
     */
    public function getPersonalizationVersion()
    {
		
		$sessionHelper = Mage::helper('printscience_personalization/session');
		//$sessionHelper->unsetData('dummy_user_version');
		$dummyuserVersion = $sessionHelper->getData('dummy_user_version');
		if($dummyuserVersion) {
			return $dummyuserVersion;
		} else {
			return 'desktop';
		}
        /*$apiUrl = Mage::getStoreConfig('catalog/personalization/api_url');
		
		$apiUrl .= "get_version/product/1";
		
		$fileContent = file_get_contents($apiUrl);
		
		//return 'mobile';
		
		if($fileContent) {
			$response = json_decode($fileContent);
			return $response->app_type;
		}
		return 'desktop';*/
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
    public function resumePersonalization($sessionKey, $productId, $templateId, $successUrl, $failUrl, $cancelUrl)
    {
        $apiUrl = Mage::getStoreConfig('catalog/personalization/api_url');
        $apiVersion = Mage::getStoreConfig('catalog/personalization/api_version');
        $client = new xmlrpc_client($apiUrl);
        $function = null;
		if($templateId!='') {
			$templateXml = php_xmlrpc_encode($templateId);
		}
        // check api version
        switch($apiVersion)
        {
            case '1.0.0':
                $function = new xmlrpcmsg('resumePersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($sessionKey),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode('')
                ));
                break;
            case '2.0.0':
                $function = new xmlrpcmsg('resumePersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($sessionKey),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
					$templateXml
                ));
                break;
            case '4.0.0':
                $function = new xmlrpcmsg('resumePersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($sessionKey),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
					$templateXml
                ));
                break;
            default:
                $function = new xmlrpcmsg('resumePersonalization', array(
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_username')),
                    php_xmlrpc_encode(Mage::getStoreConfig('catalog/personalization/api_password')),
                    php_xmlrpc_encode($sessionKey),
                    php_xmlrpc_encode($productId),
                    php_xmlrpc_encode($successUrl),
                    php_xmlrpc_encode($failUrl),
                    php_xmlrpc_encode($cancelUrl),
                    php_xmlrpc_encode(''),
					$templateXml
                ));
                break;
        }
        $response = $client->send($function);

        return new PrintScience_Personalization_Model_ApiGateway_Response_Begin($response);
    }
	public function sendCurlRequest($url, $parameter=array()) {
        try {
            /* initialize curl handle */
            $ch = curl_init();
            /* set url to send post request */
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            /* allow redirects */
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            /* return a response into a variable */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            /* times out after 30s */
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch,CURLOPT_FAILONERROR,true);
            /* set POST method */
            curl_setopt($ch, CURLOPT_POST, 1);
			/*false to SSL*/
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            /* add POST fields parameters */
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
            /* execute the cURL */
            $result = curl_exec($ch);

			// Analyse result
			if ($result === false) {
				throw new Exception(sprintf("CURL error (#%d) \"%s\". Requested URL was \"%s\".", curl_errno($ch), curl_error($ch), $url));
			}
			
            curl_close($ch);
            return $result;
        } catch (Exception $exception) {
            echo 'Exception Message: ' . $exception->getMessage() . '<br/>';
            echo 'Exception Trace: ' . $exception->getTraceAsString();
        }
    }
}
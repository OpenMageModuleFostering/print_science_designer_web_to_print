<?php
/**
 * Print Science personalization API response on getPreview function
 *
 */
class PrintScience_Personalization_Model_ApiGateway_Response_GetPreview
extends PrintScience_Personalization_Model_ApiGateway_Response_Abstract
{
    /**
     * Constructor
     *
     * @param xmlrpcresp $response
     */
    public function __construct($response)
    {
        parent::__construct($response);
    }

    /**
     * Extracts URL to the PDF proof from response
     *
     * @return string
     */
    public function getPdfUrl()
    {
		$previewUrlResponse = $this->response->value();
		foreach($previewUrlResponse->me['array'] as $previewUrlMemberMulti) {
			$pdfUrls[] =  $previewUrlMemberMulti->structMem('pdf_url')->scalarval();
		}
		return $pdfUrls;
    }

    /**
     * Extracts URLs to preview images from response
     *
     * @return array
     */
    public function getPeviewUrls()
    {
        $previewUrls = array();
        $apiVersion = Mage::getStoreConfig('catalog/personalization/api_version');
				
		$previewUrlResponse = $this->response->value();
		
		
		foreach($previewUrlResponse->me['array'] as $previewUrlMemberMulti) {
			
			$previewUrlMember = $previewUrlMemberMulti->structMem('preview_url');
			
			// check api version
			switch($apiVersion)
			{
				case '4.0.0':
					for ($i = 0; $i < $previewUrlMember->arraySize(); $i++) {
						$temp = $previewUrlMember->arrayMem($i)->scalarval();
						$previewUrls[] = $temp[1]->scalarval();
					}
					break;
				default:
					for ($i = 0; $i < $previewUrlMember->arraySize(); $i++) {
						$previewUrls[] = $previewUrlMember->arrayMem($i)->scalarval();
					}
					break;
			}
			
		}
		//exit;
        return $previewUrls;
    }
}
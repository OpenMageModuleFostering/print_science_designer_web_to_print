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
        return $this->response->value()->structMem('pdf_url')->scalarval();
    }

    /**
     * Extracts URLs to preview images from response
     *
     * @return array
     */
    public function getPeviewUrls()
    {
        $previewUrlMember = $this->response->value()->structMem('preview_url');

        $previewUrls = array();
        for ($i = 0; $i < $previewUrlMember->arraySize(); $i++) {
            $previewUrls[] = $previewUrlMember->arrayMem($i)->scalarval();
        }

        return $previewUrls;
    }
}
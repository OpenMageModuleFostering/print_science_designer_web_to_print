<?php
/**
 * Custom shopping cart item render block
 *
 */
class PrintScience_Personalization_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{    
    /**
     * Get personalization api session key of the cart item
     *
     * @return unknown
     */
    public function getPersonalizationApiSessionKey() 
    {
        $data = Mage::helper('printscience_personalization/quote')
            ->getItemData($this->getItem());
        if (!$data) {
            return false;
        }
        return $data['apiSessionKey'];
    }
    
    /**
     * Get personalization URL for cart item
     *
     * @return string | false
     */
    public function getPersonalizationUrl()
    {
        $apiSessionKey = $this->getPersonalizationApiSessionKey();
        if (!$apiSessionKey) {
            return false;
        }
        $url = Mage::getUrl('personalization/index/startShoppingCart', array(
            'api_session_key' => $apiSessionKey
        ));
        return $url;
    }
    
    /**
     * Get resume personalization URL for cart item in checkout page
     *
     * @return string | false
     */
    public function getResumePersonalizationUrl($productId)
    {
        $apiSessionKey = $this->getPersonalizationApiSessionKey();
        if (!$apiSessionKey) {
            return false;
        }
        $item = $this->getItem();
        // get simple product of configurable
        if($item->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE){
            $quoteItemId = $this->getItem()->getId();
            $mQuote = $this->getItem()->getQuote();
            $aChildQuoteItem = Mage::getModel("sales/quote_item")
                ->getCollection()
                ->setQuote($mQuote)
                ->addFieldToFilter("parent_item_id", $quoteItemId)->getFirstItem();
            if($aChildQuoteItem){
                if($aChildQuoteItem->getId()){
                    $productId = $aChildQuoteItem->getProductId();
                }
            }
        }

        $url = Mage::getUrl('personalization/index/resumeShoppingCart', array(
            'api_session_key' => $apiSessionKey,
            'product' => $productId
        ));
        return $url;
    }

    /**
     * Get URLs of personalization preview images 
     *
     * @return array | false
     */
    public function getPersonalizationPreviews()
    {
        $default = array();
        $apiSessionKey = $this->getPersonalizationApiSessionKey();
        
        $apiResponse = Mage::getModel('printscience_personalization/apiGateway')
            ->getPreview($apiSessionKey);
        if ((!$apiResponse) || ($apiResponse->getFaultCode())) {
        	$item = $this->getItem();
			
			if($personalizationInfo = $item->getData('personalization_info')){
				$personalizationInfo = unserialize($personalizationInfo);
				if(!empty($personalizationInfo['product_images'])){
					$default = $personalizationInfo['product_images'];
				}
			}
            return $default;
        }
        return $apiResponse->getPeviewUrls();
    }
}
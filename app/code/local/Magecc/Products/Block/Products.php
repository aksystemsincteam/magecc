<?php

class Magecc_Products_Block_Products extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCollection()     
    {
        $_collection = Mage::getModel('catalog/product')->getCollection();
        $_collection->addAttributeToFilter('status', array('eq' => 1));
        $_collection->addAttributeToFilter('visibility', array('eq' => 4));
        $_collection->setPageSize(30);
        $config = array();
        foreach($_collection as $product) {
            $loadProduct = Mage::getModel('catalog/product')->load($product->getEntityId());
            $mediaImages = $loadProduct->getMediaGalleryImages();
            $config[$product->getId()]['name'] = $loadProduct->getName();
            $config[$product->getId()]['description'] = $loadProduct->getDescription();
            $config[$product->getId()]['price'] = Mage::helper('core')->formatPrice($loadProduct->getPrice(), false);
            if($mediaImages){
                $i=0;
                foreach($mediaImages as $_image){
                    $config[$product->getId()]['images'][] = $_image->getUrl();
                }  
            }
        }
        return Mage::helper('core')->jsonEncode($config);
    }
}

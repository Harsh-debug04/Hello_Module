<?php
namespace AgriCart\GeoFencing\Block\Product\View;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class GeoPincode extends Template
{
    protected $_coreRegistry;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->_coreRegistry->registry('product');
    }
}
<?php
/**
 * AgriCart GeoFencing Module
 *
 * @category    AgriCart
 * @package     AgriCart_GeoFencing
 * @author      AgriCart
 * @copyright   Copyright (c) 2025 AgriCart
 */

namespace AgriCart\GeoFencing\Plugin\Product;

use AgriCart\GeoFencing\Helper\Data as GeoFencingHelper;
use Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider;

/**
 * Class AddGeoFencingDataToProvider
 * This plugin adds the Google API key to the product form's data provider,
 * making it available to UI components in the admin panel.
 */
class AddGeoFencingDataToProvider
{
    /**
     * @var GeoFencingHelper
     */
    protected $helper;

    /**
     * @param GeoFencingHelper $helper
     */
    public function __construct(GeoFencingHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param ProductDataProvider $subject
     * @param array $result
     * @return array
     */
    public function afterGetData(ProductDataProvider $subject, $result)
    {
        // The data provider's result is an array keyed by product ID.
        // We need to get the current product ID to modify the correct entry.
        $productId = $subject->getCurrentProduct()->getId();

        if ($productId && isset($result[$productId])) {
            // Add the API key to a dedicated 'geofencing' array within the product data.
            // This avoids conflicts and keeps the data organized.
            $result[$productId]['geofencing']['apiKey'] = $this->helper->getGoogleApiKey();
        }

        return $result;
    }
}

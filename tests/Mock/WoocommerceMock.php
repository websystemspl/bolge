<?php

namespace WsLicenseManager\Test\Mock;

use WsLicenseManager\App\Service\WoocommerceInterface;

class WoocommerceMock implements WoocommerceInterface
{
    public function getCreateLicenseOnStatusKey()
    {

    }

    public function wc_get_order_statuses()
    {
        return [];
    }    

    public function isWoocommerceInstalled()
    {
        return true;
    }    
}
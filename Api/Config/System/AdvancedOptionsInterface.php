<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Api\Config\System;

/**
 * Advanced options group interface
 */
interface AdvancedOptionsInterface
{
    /**
     * Config paths for 'advanced'-group
     */
    public const XML_PATH_DEBUG = 'squeezely/advanced/debug';
    public const XML_PATH_ENDPOINT_DATA_URL = 'squeezely/advanced/endpoint_data_url';
    public const XML_PATH_ENDPOINT_TRACKER_URL = 'squeezely/advanced/endpoint_tracker_url';
    public const XML_PATH_API_REQUEST_URI = 'squeezely/advanced/api_request_uri';
    public const XML_PATH_PURCHASE_INCL_TAX = 'squeezely/advanced/purchase_incl_tax';

    /**
     * Is debug log enabled
     *
     * @return bool
     */
    public function isDebugEnabled(): bool;

    /**
     * Get Endpoint Data Url
     *
     * @return string
     */
    public function getEndpointDataUrl(): string;

    /**
     * Get Endpoint Tracker Url
     *
     * @return string
     */
    public function getEndpointTrackerUrl(): string;

    /**
     * Get Api Request Uri
     *
     * @return string
     */
    public function getApiRequestUri(): string;

    /**
     * Check if use price incl tax in purchase event
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isPurchaseInclTax(int $storeId = null): bool;
}

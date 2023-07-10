<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Api\Config\System;

/**
 * Store Sync Events group interface
 */
interface StoreSyncInterface extends FrontendEventsInterface
{
    /**
     * Config paths for 'store_sync'-group
     */
    public const XML_PATH_STORESYNC_ENABLED = 'squeezely/store_sync/enabled';
    public const XML_PATH_STORESYNC_ATTRIBUTE_NAME = 'squeezely/store_sync/attribute_name';
    public const XML_PATH_STORESYNC_ATTRIBUTE_DESCRIPTION = 'squeezely/store_sync/attribute_description';
    public const XML_PATH_STORESYNC_ATTRIBUTE_BRAND = 'squeezely/store_sync/attribute_brand';
    public const XML_PATH_STORESYNC_ATTRIBUTE_SIZE = 'squeezely/store_sync/attribute_size';
    public const XML_PATH_STORESYNC_ATTRIBUTE_COLOR = 'squeezely/store_sync/attribute_color';
    public const XML_PATH_STORESYNC_ATTRIBUTE_CONDITION = 'squeezely/store_sync/attribute_condition';
    public const XML_PATH_STORESYNC_USE_PARENT_IMAGE = 'squeezely/store_sync/use_parent_image';
    public const XML_PATH_STORESYNC_LANGUAGE = 'squeezely/store_sync/language';
    public const XML_PATH_STORESYNC_LANGUAGE_CUSTOM = 'squeezely/store_sync/language_custom';
    public const XML_PATH_STORESYNC_EXTRA_FIELDS = 'squeezely/store_sync/extra_fields';
    public const XML_PATH_SYNC_CRON = 'squeezely/store_sync/cron';

    /**
     * Store Sync Enable FLag
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isStoreSyncEnabled(int $storeId = null): bool;

    /**
     * Return all enabled storeIds for product sync
     *
     * @return array
     */
    public function getAllEnabledStoreSyncStoreIds(): array;

    /**
     * Get Attribute Name
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeName(int $storeId = null): string;

    /**
     * Get Attribute Description
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeDescription(int $storeId = null): string;

    /**
     * Get Attribute Brand
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeBrand(int $storeId = null): string;

    /**
     * Get Attribute Size
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeSize(int $storeId = null): string;

    /**
     * Get Attribute Color
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeColor(int $storeId = null): string;

    /**
     * Get Attribute Condition
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getAttributeCondition(int $storeId = null): string;

    /**
     * Get Use Parent Image
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getUseParentImage(int $storeId = null): string;

    /**
     * Get Language
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getLanguage(int $storeId = null): string;

    /**
     * Get Extra fields
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getExtraFields(int $storeId = null): string;

    /**
     * Get cron frequency
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getCronFrequency(int $storeId = null): string;
}

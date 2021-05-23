<?php
/**
 * KiwiCommerce
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us https://kiwicommerce.co.uk/contacts.
 *
 * @category   KiwiCommerce
 * @package    Elgentos_InventoryLog
 * @copyright  Copyright (C) 2018 KiwiCommerce Ltd (https://kiwicommerce.co.uk/)
 * @license    https://kiwicommerce.co.uk/magento2-extension-license/
 */

namespace Elgentos\InventoryLog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface MovementRepositoryInterface
{
    /**
     * Save movement
     * @param \Elgentos\InventoryLog\Api\Data\MovementInterface $movement
     * @return \Elgentos\InventoryLog\Api\Data\MovementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Elgentos\InventoryLog\Api\Data\MovementInterface $movement
    );

    /**
     * Retrieve movement
     * @param string $movementId
     * @return \Elgentos\InventoryLog\Api\Data\MovementInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($movementId);

    /**
     * Retrieve movement matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Elgentos\InventoryLog\Api\Data\MovementSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete movement
     * @param \Elgentos\InventoryLog\Api\Data\MovementInterface $movement
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Elgentos\InventoryLog\Api\Data\MovementInterface $movement
    );

    /**
     * Delete movement by ID
     * @param string $movementId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($movementId);
}

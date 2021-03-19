<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\GiftCardGraphQl\Model\Resolver\DataProvider;


use Ecomteck\GiftCardAccount\Api\GiftCardAccountManagementInterface;
use Ecomteck\GiftCardAccount\Model\GiftcardaccountFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class GiftCardInfo
 * @package Lof\GiftCardGraphQl\Model\Resolver\DataProvider
 */
class GiftCardInfo
{

    /**
     * @var GiftCardAccountManagementInterface
     */
    private $giftCartAccountManagement;
    /**
     * @var GiftcardaccountFactory
     */
    private $giftCartAccountFactory;

    /**
     * GiftCardInfo constructor.
     * @param GiftCardAccountManagementInterface $giftCardAccountManagement
     * @param GiftcardaccountFactory $giftCardAccountFactory
     */
    public function __construct(
        GiftCardAccountManagementInterface $giftCardAccountManagement,
        GiftcardaccountFactory $giftCardAccountFactory
    )
    {
        $this->giftCartAccountManagement = $giftCardAccountManagement;
        $this->giftCartAccountFactory = $giftCardAccountFactory;

    }

    /**
     * @param string $code
     * @return string
     */
    public function getGiftCardInfo($code)
    {
        return $this->giftCartAccountManagement->getGiftCardAmount($code);
    }

    /**
     * @param string $code
     * @param string $customerId
     * @return array
     * @throws LocalizedException
     */
    public function RedeemGiftCart($code, $customerId) {
        $giftCartAccount = $this->giftCartAccountFactory->create();
        $giftCartAccount->loadByCode($code)->redeem($customerId);
        return [
            "code" => 0,
            "message" => __("Gift cart %1 was redeemed.",$code)
        ];
    }

    /**
     * @param string $cartId
     * @param string $code
     * @return array
     */
    public function AddGiftCardToCart($cartId, $code) {
        $this->giftCartAccountManagement->addGiftCardToCart($cartId, $code);
        return [
            "code" => 0,
            "message" => __("Gift cart %1 was added.", $code)
        ];
    }
}


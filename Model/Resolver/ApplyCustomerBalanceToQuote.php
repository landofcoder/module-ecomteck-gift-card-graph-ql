<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\GiftCardGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;

class ApplyCustomerBalanceToQuote implements ResolverInterface
{

    private $giftCardInfoDataProvider;
    /**
     * @var GetCartForUser
     */
    private $getCartForUser;

    /**
     * @param DataProvider\GiftCardInfo $giftCardInfoDataProvider
     * @param GetCartForUser $getCartForUser
     */
    public function __construct(
        DataProvider\GiftCardInfo $giftCardInfoDataProvider,
        GetCartForUser $getCartForUser
    ) {
        $this->giftCardInfoDataProvider = $giftCardInfoDataProvider;
        $this->getCartForUser = $getCartForUser;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        /** @var ContextInterface $context */
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('The current user isn\'t authorized.'));
        }
        $maskedCartId = $args['cart_id'];

        $storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
        $cart = $this->getCartForUser->execute($maskedCartId, $context->getUserId(), $storeId);

        return $this->giftCardInfoDataProvider->ApplyCustomerBalanceToQuote($cart->getId());
    }
}


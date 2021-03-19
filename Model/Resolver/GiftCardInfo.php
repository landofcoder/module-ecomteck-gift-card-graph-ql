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

class GiftCardInfo implements ResolverInterface
{

    private $giftCardInfoDataProvider;

    /**
     * @param DataProvider\GiftCardInfo $giftCardInfoDataProvider
     */
    public function __construct(
        DataProvider\GiftCardInfo $giftCardInfoDataProvider
    ) {
        $this->giftCardInfoDataProvider = $giftCardInfoDataProvider;
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
        return $this->giftCardInfoDataProvider->getGiftCardInfo($args['code']);
    }
}


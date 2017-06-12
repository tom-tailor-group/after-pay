<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilTextInterface;
use \ArrayObject;

class TransferToCamelCaseArrayConverter implements TransferToCamelCaseArrayConverterInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilTextInterface
     */
    protected $utilText;

    /**
     * @param \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilTextInterface $utilText
     */
    public function __construct(AfterpayToUtilTextInterface $utilText)
    {
        $this->utilText = $utilText;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return mixed
     */
    public function convert(AbstractTransfer $transfer)
    {
        return $this->convertTransferRecursively($transfer);
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return array
     */
    protected function convertTransferRecursively(AbstractTransfer $transfer)
    {
        $originalArray = $transfer->toArray(false);
        $camelCaseArray = [];

        foreach ($originalArray as $key => $value) {
            $camelCaseKey = $this->underscoreToCamelCase($key);

            if ($value instanceof AbstractTransfer) {
                $camelCaseArray[$camelCaseKey] = $this->convertTransferRecursively($value);
            }

            if ($value instanceof ArrayObject) {
                $camelCaseArray[$camelCaseKey] = [];
                foreach ($value as $valueItem) {
                    $camelCaseArray[$camelCaseKey][] = $this->convertTransferRecursively($valueItem);
                }
            }

            if (is_scalar($value)) {
                $camelCaseArray[$camelCaseKey] = $value;
            }
        }

        return $camelCaseArray;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function underscoreToCamelCase($string)
    {
        return $this->utilText->separatorToCamelCase($string, '_');
    }

}
<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Mapper;

use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AfterpayRequestAddressTransfer;
use Generated\Shared\Transfer\AfterpayRequestCustomerTransfer;
use Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer;
use Generated\Shared\Transfer\AfterpayRequestOrderTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface;

class QuoteToRequestTransfer implements QuoteToRequestTransferInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface
     */
    protected $money;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @param \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface $money
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(AfterpayToMoneyInterface $money, Store $store)
    {
        $this->money = $money;
        $this->store = $store;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer
     */
    public function quoteToAvailablePaymentMethods(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new AfterpayAvailablePaymentMethodsRequestTransfer();

        $requestTransfer
            ->setCustomer(
                $this->buildCustomerRequestTransfer($quoteTransfer)
            )
            ->setOrder(
                $this->buildOrderRequestTransfer($quoteTransfer)
            );

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestCustomerTransfer
     */
    protected function buildCustomerRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        $quoteBillingAddressTransfer = $quoteTransfer->getBillingAddress();
        $customerRequestTransfer = new AfterpayRequestCustomerTransfer();

        $customerRequestTransfer
            ->setFirstName($quoteBillingAddressTransfer->getFirstName())
            ->setLastName($quoteBillingAddressTransfer->getLastName())
            ->setConversationalLanguage($this->getStoreCountryIso2())
            ->setCustomerCategory(AfterpayConstants::API_CUSTOMER_CATEGORY_PERSON)
            ->setSalutation($quoteBillingAddressTransfer->getSalutation())
            ->setEmail($quoteTransfer->getCustomer()->getEmail());

        $customerRequestTransfer->setAddress(
            $this->buildCustomerBillingAddressRequestTransfer($quoteTransfer)
        );

        return $customerRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestOrderTransfer
     */
    protected function buildOrderRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        $orderRequestTransfer = new AfterpayRequestOrderTransfer();
        $orderRequestTransfer->setTotalGrossAmount($this->getDecimalQuoteTotal($quoteTransfer));

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $orderRequestTransfer->addItem(
                $this->buildOrderItemRequestTransfer($itemTransfer)
            );
        }

        return $orderRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer
     */
    protected function buildOrderItemRequestTransfer(ItemTransfer $itemTransfer)
    {
        $orderItemRequestTransfer = new AfterpayRequestOrderItemTransfer();

        $orderItemRequestTransfer
            ->setProductId($itemTransfer->getSku())
            ->setDescription($itemTransfer->getName())
            ->setGrossUnitPrice($this->getDecimalItemGrossUnitPrice($itemTransfer))
            ->setQuantity($itemTransfer->getQuantity());

        return $orderItemRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestAddressTransfer
     */
    protected function buildCustomerBillingAddressRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        $customerAddressTransfer = $quoteTransfer->getBillingAddress();
        $customerAddressRequestTransfer = new AfterpayRequestAddressTransfer();

        $customerAddressRequestTransfer
            ->setCountryCode($customerAddressTransfer->getIso2Code())
            ->setStreet($customerAddressTransfer->getAddress1())
            ->setStreetNumber($customerAddressTransfer->getAddress2())
            ->setPostalCode($customerAddressTransfer->getZipCode())
            ->setPostalPlace($customerAddressTransfer->getCity());

        return $customerAddressRequestTransfer;
    }

    /**
     * @return string
     */
    protected function getStoreCountryIso2()
    {
        return $this->store->getCurrentCountry();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return float
     */
    protected function getDecimalQuoteTotal(QuoteTransfer $quoteTransfer)
    {
        $quoteTotal = $quoteTransfer->getTotals()->getGrandTotal();

        return $this->money->convertIntegerToDecimal($quoteTotal);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return float
     */
    protected function getDecimalItemGrossUnitPrice(ItemTransfer $itemTransfer)
    {
        $itemUnitGrossPrice = $itemTransfer->getUnitGrossPriceWithProductOptionAndDiscountAmounts();

        return $this->money->convertIntegerToDecimal($itemUnitGrossPrice);
    }

}

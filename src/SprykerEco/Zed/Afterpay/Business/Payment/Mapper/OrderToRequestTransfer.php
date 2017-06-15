<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Mapper;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayRequestAddressTransfer;
use Generated\Shared\Transfer\AfterpayRequestCustomerTransfer;
use Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer;
use Generated\Shared\Transfer\AfterpayRequestOrderTransfer;
use Generated\Shared\Transfer\AfterpayRequestPaymentTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface;

class OrderToRequestTransfer implements OrderToRequestTransferInterface
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
     * @var array
     */
    protected static $paymentMethods = [
        AfterpayConstants::PAYMENT_METHOD_INVOICE => AfterpayConstants::PAYMENT_TYPE_INVOICE,
    ];

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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer
     */
    public function orderToAuthorizeRequest(OrderTransfer $orderWithPaymentTransfer)
    {
        $requestTransfer = new AfterpayAuthorizeRequestTransfer();

        $requestTransfer
            ->setFkSalesOrder($orderWithPaymentTransfer->getIdSalesOrder())
            ->setPayment(
                $this->buildPaymentRequestTransfer($orderWithPaymentTransfer)
            )
            ->setCustomer(
                $this->buildCustomerRequestTransfer($orderWithPaymentTransfer)
            )
            ->setOrder(
                $this->buildOrderRequestTransfer($orderWithPaymentTransfer)
            );

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestCustomerTransfer
     */
    protected function buildCustomerRequestTransfer(OrderTransfer $orderWithPaymentTransfer)
    {
        $billingAddressTransfer = $orderWithPaymentTransfer->getBillingAddress();
        $customerRequestTransfer = new AfterpayRequestCustomerTransfer();

        $customerRequestTransfer
            ->setFirstName($billingAddressTransfer->getFirstName())
            ->setLastName($billingAddressTransfer->getLastName())
            ->setConversationalLanguage($this->getStoreCountryIso2())
            ->setCustomerCategory(AfterpayConstants::API_CUSTOMER_CATEGORY_PERSON)
            ->setSalutation($billingAddressTransfer->getSalutation())
            ->setEmail($orderWithPaymentTransfer->getEmail());

        $customerRequestTransfer->setAddress(
            $this->buildCustomerBillingAddressRequestTransfer($orderWithPaymentTransfer)
        );

        return $customerRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestOrderTransfer
     */
    protected function buildOrderRequestTransfer(OrderTransfer $orderWithPaymentTransfer)
    {
        $orderRequestTransfer = new AfterpayRequestOrderTransfer();
        $orderRequestTransfer
            ->setNumber($orderWithPaymentTransfer->getOrderReference())
            ->setTotalGrossAmount($this->getDecimalOrderTotal($orderWithPaymentTransfer));

        foreach ($orderWithPaymentTransfer->getItems() as $itemTransfer) {
            $orderRequestTransfer->addItem(
                $this->buildOrderItemRequestTransfer($itemTransfer)
            );
        }

        return $orderRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestPaymentTransfer
     */
    protected function buildPaymentRequestTransfer(OrderTransfer $orderWithPaymentTransfer)
    {
        $paymentMethod = $orderWithPaymentTransfer->getAfterpayPayment()->getPaymentMethod();

        $requestPaymentTransfer = new AfterpayRequestPaymentTransfer();
        $requestPaymentTransfer->setType(static::$paymentMethods[$paymentMethod]);

        return $requestPaymentTransfer;
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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRequestAddressTransfer
     */
    protected function buildCustomerBillingAddressRequestTransfer(OrderTransfer $orderWithPaymentTransfer)
    {
        $customerAddressTransfer = $orderWithPaymentTransfer->getBillingAddress();
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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return float
     */
    protected function getDecimalOrderTotal(OrderTransfer $orderWithPaymentTransfer)
    {
        $orderTotal = $orderWithPaymentTransfer->getTotals()->getGrandTotal();

        return $this->money->convertIntegerToDecimal($orderTotal);
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

<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface AfterpayFacadeInterface
{

    /**
     * Specification:
     * - Makes a call to the "payment-methods" API endpoint, to get a list of payment methods,
     * available for the current quote, with additional information - checkout_id, and risk_check_score
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsTransfer
     */
    public function getAvailablePaymentMethods(QuoteTransfer $quoteTransfer);

    /**
     * Specification:
     * - Makes a call to the "validate-address" API endpoint, to validate customer address.
     * Response contains isValid flag along with correctedAddress.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function validateCustomerAddress(
        AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
    );

    /**
     * Specification:
     * - Sends payment authorize request to Afterpay gateway.
     * - Saves the transaction result in DB for future recognition
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayResponseTransfer
     */
    public function authorizePayment(OrderTransfer $orderTransfer);

    /**
     * Specification:
     * - Sends payment capture request to Afterpay gateway, to capture payment for a specific order item.
     * - Saves the transaction result in DB and sets payment state as "captured" for the payment item.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayResponseTransfer
     */
    public function capturePayment(ItemTransfer $itemTransfer);

    /**
     * Specification:
     * - Saves order payment method data according to quote and checkout response transfer data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer);

    /**
     * Specification:
     *  - Requests Afterpay API version and returns the result.
     *
     * @api
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Specification:
     *  - Requests Afterpay API HTTP status and returns the result.
     *
     * @api
     *
     * @return int
     */
    public function getApiStatus();

}

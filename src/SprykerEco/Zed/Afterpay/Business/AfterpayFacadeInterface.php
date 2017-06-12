<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\AfterpayAuthorizeTransactionLogRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface AfterpayFacadeInterface
{

    /**
     * Specification:
     *  - Executes a post save hook for the following payment methods:
     *    Sofort / authorize: checks for an external redirect URL in transaction log and redirects customer to the payment system
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function postSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer);

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
     * - Fetches authorise transaction for a given order by idSalesOrder
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeTransactionLogRequestTransfer $authorizeLogRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayTransactionLogTransfer
     */
    public function getAuthorizeTransactionLog(AfterpayAuthorizeTransactionLogRequestTransfer $authorizeLogRequestTransfer);

}

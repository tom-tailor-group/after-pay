<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

/**
 * @method \SprykerEco\Zed\Afterpay\Persistence\AfterpayPersistenceFactory getFactory()
 */
class AfterpayQueryContainer extends AbstractQueryContainer implements AfterpayQueryContainerInterface
{

    const TRANSACTION_TYPE_AUTHORIZE = AfterpayConstants::TRANSACTION_TYPE_AUTHORIZE;
    const TRANSACTION_TYPE_CAPTURE = AfterpayConstants::TRANSACTION_TYPE_CAPTURE;
    const TRANSACTION_TYPE_CANCEL = AfterpayConstants::TRANSACTION_TYPE_CANCEL;
    const TRANSACTION_TYPE_REFUND = AfterpayConstants::TRANSACTION_TYPE_REFUND;

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryAuthorizeTransactionLog($idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentAfterpayTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType(static::TRANSACTION_TYPE_AUTHORIZE);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryCaptureTransactionLog($idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentAfterpayTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType(static::TRANSACTION_TYPE_CAPTURE);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryCancelTransactionLog($idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentAfterpayTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType(static::TRANSACTION_TYPE_CANCEL);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryRefundTransactionLog($idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentAfterpayTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType(static::TRANSACTION_TYPE_REFUND);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayQuery
     */
    public function queryPaymentByIdSalesOrder($idSalesOrder)
    {
        return $this
            ->getFactory()
            ->createPaymentAfterpayQuery()
            ->filterByFkSalesOrder($idSalesOrder);
    }

    /**
     * @api
     *
     * @param int $idSalesOrderItem
     * @param int $idPayment
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayOrderItemQuery
     */
    public function queryPaymentOrderItemByIdSalesOrderAndIdPayment($idSalesOrderItem,$idPayment)
    {
        return $this
            ->getFactory()
            ->createPaymentAfterpayOrderItemQuery()
            ->filterByFkSalesOrderItem($idSalesOrderItem)
            ->filterByFkPaymentAfterpay($idPayment);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     * @param string $transactionType
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryTransactionByIdSalesOrderAndType($idSalesOrder, $transactionType)
    {
        return $this->getFactory()
            ->createPaymentAfterpayTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType($transactionType);
    }

}

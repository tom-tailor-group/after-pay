<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Communication\Plugin\Checkout\Oms\Condition;

use Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLog;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

/**
 * @method \SprykerEco\Zed\Afterpay\Business\AfterpayFacade getFacade()
 * @method \SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainer getQueryContainer()
 * @method \SprykerEco\Zed\Afterpay\Communication\AfterpayCommunicationFactory getFactory()
 */
class IsCaptureCompletedPlugin extends AbstractPlugin implements ConditionInterface
{

    const FULL_CAPTURE_TRANSACTION_ACCEPTED = AfterpayConstants::API_TRANSACTION_OUTCOME_ACCEPTED;

    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        return $this->isFullCaptureTransactionSuccessful($orderItem->getFkSalesOrder());
    }

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    protected function isFullCaptureTransactionSuccessful($idSalesOrder)
    {
        $fullCaptureTransactionLog = $this->getFullCaptureTransactionLogEntry($idSalesOrder);
        if ($fullCaptureTransactionLog === null) {
            return false;
        }

        return $this->isTransactionSuccessful($fullCaptureTransactionLog);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLog|null
     */
    protected function getFullCaptureTransactionLogEntry($idSalesOrder)
    {
        $transactionLogQuery = $this->getQueryContainer()->queryAuthorizeTransactionLog($idSalesOrder);

        return $transactionLogQuery->findOne();
    }

    /**
     * @param \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLog $fullCaptureTransactionLog
     *
     * @return bool
     */
    protected function isTransactionSuccessful(SpyPaymentAfterpayTransactionLog $fullCaptureTransactionLog)
    {
        return $fullCaptureTransactionLog->getOutcome() === static::FULL_CAPTURE_TRANSACTION_ACCEPTED;
    }

}

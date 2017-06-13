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
class IsAuthorizationCompletedPlugin extends AbstractPlugin implements ConditionInterface
{

    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        return true;
//            $this->hasCustomerCompletedAuthorization($orderItem->getFkSalesOrder());
    }

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    protected function hasCustomerCompletedAuthorization($idSalesOrder)
    {
        $externalTransactionLog = $this->getExternalTransactionLogEntry($idSalesOrder);
        if ($externalTransactionLog === null) {
            return false;
        }

        return $this->isTransactionSuccessful($externalTransactionLog);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLog|null
     */
    protected function getExternalTransactionLogEntry($idSalesOrder)
    {
        $transactionLogQuery = $this->getQueryContainer()->queryAuthorizeTransactionLog($idSalesOrder);
        return $transactionLogQuery->findOne();
    }

    /**
     * @param \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLog $externalTransactionLog
     *
     * @return bool
     */
    protected function isTransactionSuccessful(SpyPaymentAfterpayTransactionLog $externalTransactionLog)
    {
        return $externalTransactionLog->getResponseCode() === static::EXTERNAL_RESPONSE_TRANSACTION_STATUS_OK;
    }

}

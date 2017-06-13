<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface AfterpayQueryContainerInterface extends QueryContainerInterface
{

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayQuery
     */
    public function queryPaymentByIdSalesOrder($idSalesOrder);

    /**
     * @api
     *
     * @param int $idSalesOrder
     * @param string $transactionType
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryTransactionByIdSalesOrderAndType($idSalesOrder, $transactionType);

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayTransactionLogQuery
     */
    public function queryAuthorizeTransactionLog($idSalesOrder);

}

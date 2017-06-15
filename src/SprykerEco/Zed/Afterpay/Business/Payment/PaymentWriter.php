<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment;

use SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainerInterface;

class PaymentWriter implements PaymentWriterInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainerInterface
     */
    protected $afterpayQueryContainer;

    /**
     * @param \SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainerInterface $afterpayQueryContainer
     */
    public function __construct(AfterpayQueryContainerInterface $afterpayQueryContainer)
    {
        $this->afterpayQueryContainer = $afterpayQueryContainer;
    }

    /**
     * @param string $idReservation
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function setIdReservationByIdSalesOrder($idReservation, $idSalesOrder)
    {
        $afterpayPaymentEntity = $this->getPaymentEntityByIdSalesOrder($idSalesOrder);

        $afterpayPaymentEntity
            ->setIdReservation($idReservation)
            ->save();
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpay
     */
    protected function getPaymentEntityByIdSalesOrder($idSalesOrder)
    {
        $afterpayPaymentEntity = $this->afterpayQueryContainer
            ->queryPaymentByIdSalesOrder($idSalesOrder)
            ->findOne();

        return $afterpayPaymentEntity;
    }

}

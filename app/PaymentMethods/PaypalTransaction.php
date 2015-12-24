<?php namespace Registration\PaymentMethods;

class PaypalTransaction extends AbstractTransaction
{

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod()
    {
        return new PaypalMethod();
    }
}
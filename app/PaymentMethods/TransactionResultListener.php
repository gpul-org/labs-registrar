<?php namespace Registration\PaymentMethods;


interface TransactionResultListener
{
    public function transactionFail(AbstractTransaction $tx, $errorMsg = "");

    public function transactionOk(AbstractTransaction $tx);
}
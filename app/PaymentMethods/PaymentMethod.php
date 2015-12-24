<?php namespace Registration\PaymentMethods;


use Registration\Repositories\TransactionRepository;
use Registration\TierDescriptor;

interface PaymentMethod
{
    public static function getName();

    public function handle($concept, $price);

    public function formUrl();
}

interface TwoStepPaymentMethod extends PaymentMethod
{
    public function finalizeTransaction(TierDescriptor $tiers, TransactionRepository $transactions, TransactionResultListener $resultListener);
}
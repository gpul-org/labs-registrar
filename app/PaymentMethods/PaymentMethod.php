<?php namespace Registration\PaymentMethods;


interface PaymentMethod
{
    public static function getName();
    public function handle($concept, $price, $invoiceNo);
}
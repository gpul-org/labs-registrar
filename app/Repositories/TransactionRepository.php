<?php namespace Registration\Repositories;


use Illuminate\Contracts\Auth\Authenticatable;
use Registration\PaymentMethods\AbstractTransaction;
use Registration\Transaction;

class TransactionRepository
{
    public function saveOrUpdateTransaction(AbstractTransaction $transaction)
    {
        Transaction::updateOrCreate([
            "status" => $transaction->getStatus(),
            "txid" => $transaction->getTxId(),
            "provider" => $transaction->getPaymentMethod()->getName(),
            "buyer_id" => $transaction->getBuyerId(),
            "money" => $transaction->getMoney(),
            "product" => $transaction->getProduct(),
            "extra" => $transaction->getExtra(),
        ]);
    }

    public function getUserTransactions(Authenticatable $user)
    {
        return Transaction::where('buyer_id', $user->getAuthIdentifier())->get();
    }

    public function getUserTier(Authenticatable $user)
    {
        $tx = Transaction::where('buyer_id', $user->getAuthIdentifier())->first();

        return isset($tx) ? $tx->product : null;
    }

}
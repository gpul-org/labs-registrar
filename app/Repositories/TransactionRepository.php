<?php namespace Registration\Repositories;


use Illuminate\Contracts\Auth\Authenticatable;
use Registration\PaymentMethods\AbstractTransaction;
use Registration\Transaction;

class TransactionRepository
{

    /**
     * @param AbstractTransaction $transaction
     * @return Transaction
     */
    public static function saveOrUpdateTransaction(AbstractTransaction $transaction)
    {
        return Transaction::updateOrCreate([
            "status" => $transaction->getStatus(),
            "txid" => $transaction->getTxId(),
            "provider" => $transaction->getPaymentMethod()->getName(),
            "buyer_id" => $transaction->getBuyerId(),
            "money" => $transaction->getMoney(),
            "product" => $transaction->getProduct(),
            "extra" => $transaction->getExtra(),
        ]);
    }

    /**
     * @param Authenticatable $user
     * @return Transaction[]
     */
    public static function getUserTransactions(Authenticatable $user)
    {
        return Transaction::where('buyer_id', $user->getAuthIdentifier())->get();
    }

    /**
     * @param Authenticatable $user
     * @return string|null
     */
    public static function getUserTier(Authenticatable $user)
    {
        $tx = Transaction::where('buyer_id', $user->getAuthIdentifier())->first();

        return isset($tx) ? $tx->product : null;
    }

}
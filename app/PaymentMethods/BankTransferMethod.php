<?php namespace Registration\PaymentMethods;


use Registration\Repositories\TransactionRepository;
use Registration\TierDescriptor;
use Registration\Transaction;

class BankTransferIntent extends AbstractTransaction
{

    /**
     * @return BankTransferMethod
     */
    public function getPaymentMethod()
    {
        return new BankTransferMethod();
    }
}


class BankTransferMethod implements PaymentMethod
{
    public $bic;
    public $iban;
    public $holder;
    public $branch;
    /**
     * @var TransactionRepository
     */
    protected $transactions;

    function __construct()
    {
        $this->iban = env('BANK_ACCT_IBAN', 'IBAN ESXX XXXX XXXX XXXX XXXX XXXX');
        $this->bic = env('BANK_ACCT_BIC', 'BICXXX');
        $this->holder = env('BANK_ACCT_HOLDER', _('You do not need this information'));
        $this->branch = env('BANK_ACCT_BRANCH', _('You do not need this information'));
    }

    public function formUrl()
    {
        return action('PaymentController@merchantHandle', self::getName());
    }

    public static function getName()
    {
        return "bankTransfer";
    }

    public function handle($concept, $price)
    {
        $txId = $this->findNextTxId();
        $status = "pending";
        $uid = \Auth::user()->getAuthIdentifier();

        $tx = new BankTransferIntent($txId, $status, $uid, $price, $concept, ["paymentRegistered" => false]);
        return TransactionRepository::saveOrUpdateTransaction($tx);
    }

    public function findNextTxId()
    {
        $uid = \Auth::user()->getAuthIdentifier();
        $transfers = count(Transaction::query()->where('buyer_id', $uid)->where('provider', $this->getName())->get('txid'));
        return "U{$uid}TX{$transfers}A0";
    }

    /**
     * @param TierDescriptor $_tiers
     * @param TransactionRepository $_transactions
     * @param TransactionResultListener $resultListener
     */
    public function finalizeTransaction(TierDescriptor $_tiers, TransactionRepository $_transactions, TransactionResultListener $resultListener)
    {
        $resultListener->transactionFail(null, _("You must pay the amount via wire transfer and then request review status by a staff member for this transaction method."));
    }
}
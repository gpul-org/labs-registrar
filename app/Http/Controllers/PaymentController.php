<?php namespace Registration\Http\Controllers;


use Auth;
use Registration\AlertMsg;
use Registration\PaymentMethods\AbstractTransaction;
use Registration\PaymentMethods\BankTransferMethod;
use Registration\PaymentMethods\PaypalMethod;
use Registration\PaymentMethods\TransactionResultListener;
use Registration\Repositories\TransactionRepository;
use Registration\TierDescriptor;
use Request;
use Session;

class PaymentController extends Controller implements TransactionResultListener
{
    public function welcome(TierDescriptor $descriptor, TransactionRepository $transactions)
    {
        $tier = $transactions->getUserTier(Auth::user());

        if ($tier != 'free') {
            Session::now("heading_msgs",
                array_merge(
                    Session::get("heading_msgs", []),
                    [new AlertMsg(
                        "alert-warning",
                        sprintf(_("You have already registered for the <strong>%s</strong> tier."), $tier)
                    )]
                )
            );
        }

        return view('payment.storefront', [
            'tiers' => $descriptor->getTiers(),
            'errorMsg' => Request::session()->get('txErrorMsg'),
        ]);
    }

    public function logs(TransactionRepository $transactions)
    {
        return view('payment.logs', [
            'transactions' => $transactions->getUserTransactions(Auth::user())
        ]);
    }

    public function tierSelect($tier, TierDescriptor $descriptor)
    {
        return view('payment.confirm_prepay', [
            'tier' => $descriptor->getTier($tier),
            'tierName' => $tier,
        ]);
    }

    public function selectPayment($tier, TierDescriptor $descriptor, PaypalMethod $paypal, BankTransferMethod $bankTransfer)
    {
        return view('payment.options', [
            'tierName' => $tier,
            'tier' => $descriptor->getTier($tier),
            'price' => $descriptor->getTierPrice($tier),
            'paypal' => $paypal,
            'bankTransfer' => $bankTransfer,
        ]);
    }

    public function confirmFree()
    {
        return "TBD";
    }

    /**
     * @param string $merchant currently only PayPal is supported
     * @param TierDescriptor $tiers
     * @param PaypalMethod $paypal
     * @param TransactionRepository $transactions
     * @return
     * @throws \Exception
     */
    public function merchantCallback($merchant, TierDescriptor $tiers, PaypalMethod $paypal, TransactionRepository $transactions)
    {
        if ($merchant == "paypal") {
            return $paypal->finalizeTransaction($tiers, $transactions, $this);
        } else {
            throw new \Exception("Not implemented yet");
        }
    }

    public function merchantHandle($merchant, BankTransferMethod $bank, TierDescriptor $tiers)
    {
        $concept = Request::input('tier');
        $price = $tiers->getTierPrice($concept);

        if ($merchant == "bankTransfer") {
            return $bank->handle($concept, $price);
        } else {
            throw new \Exception("Not implemented yet");
        }
    }

    public function confirmTier(TransactionRepository $transactions)
    {

        $tier = $transactions->getUserTier(Auth::user());
        $tier = $tier ? $tier : 'free';

        $msg = Request::session()->get('lastPayment');
        return view('payment.confirmed', [
            'tier' => $tier,
            'lastTxMsg' => $msg,
        ]);
    }

    public function transactionFail(AbstractTransaction $tx, $errorMsg = "")
    {
        // Add flash msg and redirect to storefront
        Request::session()->flash("txErrorMsg", $errorMsg);
        return redirect(action("PaymentController@welcome"));
    }

    public function transactionOk(AbstractTransaction $tx)
    {
        Request::session()->flash("lastPayment", $tx->toArray());
        return redirect(action('PaymentController@confirmTier'));
    }
}
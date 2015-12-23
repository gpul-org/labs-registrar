<?php  namespace Registration\PaymentMethods;


use Auth;
use Illuminate\Support\Facades\Request;
use Registration\Repositories\TransactionRepository;
use Registration\TierDescriptor;

class PaypalTransaction extends AbstractTransaction {

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod()
    {
        return new PaypalMethod();
    }
}

class PaypalMethod implements PaymentMethod
{
    public static function getName()
    {
        return 'paypal';
    }

    public function handle($concept, $price, $invoiceNo)
    {

    }

    public function finalizeTransaction(TierDescriptor $tiers, TransactionRepository $transactions, TransactionResultListener $resultListener)
    {
        $txId = Request::get("tx");
        $st = Request::get('st');
        $amt = Request::get('amt');

        $r = $this->callPayPalAPI($this->formUrl(), [
            "cmd" => "_notify-synch",
            "tx" => $txId,
            "at" => $this->pdtToken(),
            "submit" => "PDT",
        ]);

        if($r[0] == "SUCCESS") {
            $status = "success";
        } else {
            $status = $r[0];
        }

        $buyerId = Auth::user()->getAuthIdentifier();
        $money = $r['mc_gross'];
        $product = array_get($r, 'custom', 'free');
        $tierPrice = floatval($tiers->getTierPrice($product));

        if ($tierPrice > floatval($money)) {
            return $resultListener->transactionFail(null, sprintf(_("You did not pay the full amount of the price for the item! (For further information, the transaction id is %s)"), $txId));
        }

        $extra = json_encode($r);

        $tx = new PaypalTransaction($txId, $status, $buyerId, $money, $product, $extra);


        if($tx->getStatus() == "success") {
            $transactions->saveOrUpdateTransaction($tx);
            return $resultListener->transactionOk($tx);
        } else {
            return $resultListener->transactionFail($tx, sprintf(_("The transaction did not commit. The current status is %s"), $tx->getStatus()));
        }


    }

    protected function callPayPalAPI($url, $data = false) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        if($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = explode("\n", curl_exec($curl));
        curl_close($curl);

        $robj = [];
        foreach($result as $line) {
            $eq = strpos($line, "=");
            if($eq !== false) {
                $key = substr($line, 0, $eq);
                $val = substr($line, $eq + 1);
                $robj[$key] = $val;
            } elseif(strlen($line) > 0) {
                $robj[0] = $line;
                $robj['status'] = $line;
            }
        }

        return $robj;
    }

    public function formUrl()
    {
        return env('PAYPAL_FORMURL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
    }

    protected function pdtToken()
    {
        return env('PAYPAL_PDTTOKEN');
    }

    public function imageUrl() {
        return env('PAYPAL_CHECKOUTLOGO', 'https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png');
    }

}
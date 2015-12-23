<?php namespace Registration\PaymentMethods;


abstract class AbstractTransaction
{
    protected $txId;
    protected $buyer_id;
    protected $status;
    protected $money;
    protected $product;
    protected $extra;

    /**
     * PaypalTransaction constructor.
     * @param $txId
     * @param $status
     * @param $buyer_id
     * @param $money
     * @param $product
     * @param $extra
     */
    public function __construct($txId, $status, $buyer_id, $money, $product, $extra)
    {
        $this->txId = $txId;
        $this->status = $status;
        $this->buyer_id = $buyer_id;
        $this->money = $money;
        $this->product = $product;
        $this->extra = $extra;
    }

    /**
     * @return PaypalMethod
     */
    abstract public function getPaymentMethod();

    public function getName()
    {
        return $this->getPaymentMethod()->getName();
    }

    /**
     * @return string
     */
    public function getTxId()
    {
        return $this->txId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getBuyerId()
    {
        return $this->buyer_id;
    }

    /**
     * @return mixed
     */
    public function getMoney()
    {
        return floatval($this->money);
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "txId" => $this->getTxId(),
            "status" => $this->getStatus(),
            "buyer_id" => $this->getBuyerId(),
            "money" => $this->getMoney(),
            "product" => $this->getProduct(),
            "extra" => $this->getExtra(),
        ];
    }

}
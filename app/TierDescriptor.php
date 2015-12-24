<?php namespace Registration;

class Tier {
    public $name;
    public $advantages;
    public $requirements;
    public $price;

    /**
     * Tier constructor.
     * @param string $name
     * @param array $advantages
     * @param array $requirements
     * @param string $price
     */
    public function __construct($name, $advantages, $requirements, $price)
    {
        $this->name = $name;
        $this->advantages = $advantages;
        $this->requirements = $requirements;
        $this->price = $price;
    }

    public static function fromArray($arr)
    {
        return new self($arr['name'], $arr['advantages'], array_get($arr, 'requirements', array()), $arr['price']);
    }

    public function isFree() {
        return $this->price == "FREE";
    }

}

class TierDescriptor
{
    private $tiers;

    public function __construct() {
       $this->tiers = [
            "free" => [
                "name" => "Free Access",
                "advantages" => [
                    _("Access to the lectures and workshops"),
                    _("Certificate of assistance for individual lectures"),
                ],
                "price" => "FREE",
            ],

           "student" => [
               "name" => "Student Tier",
               "advantages" => [
                   _("Guaranteed access to the lectures and workshops"),
                   _("Verifiable statement of completion for lectures and the whole project"),
                   _("A merchandise pack"),
               ],
               "requirements" => [
                   _("Be a student of the University of A Coruña"),
               ],
               "price" => "49.95",
           ],
           "premium" => [
               "name" => "Elite Tier",
               "price" => "89.95",
           ]
        ];

        $this->tiers['premium']['advantages'] = $this->tiers['student']['advantages'];

        $this->tiers = array_map([Tier::class, 'fromArray'], $this->tiers);
    }

    public function getTiers() {
        $b = $this->tiers; // Make copy of array
        return $b;
    }

    /**
     * @param string $tier
     * @return string
     */
    public function getTierPrice($tier) {
        return array_get($this->tiers, $tier, NULL)->price;
    }

    /**
     * @param $tier
     * @return Tier
     */
    public function getTier($tier)
    {
        return array_get($this->tiers, $tier);
    }

}
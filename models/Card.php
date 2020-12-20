<?php 

class Card{
    private $id;
    private $user_id;
    private $card_number;
    private $money_amount;
    private $db;

    // recordar que el metodo construct se corre automaticamente cuando se crea el objeto
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }
    public function setCard_number($card_number){
        $this->card_number = $this->db->real_escape_string($card_number);
    }
    public function setMoney_amount($money_amount){
        $this->money_amount = $this->db->real_escape_string($money_amount);
    }

    public function getId(){
        return $this->id;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function getCard_number(){
        return $this->card_number;
    }
    public function getMoney_amount(){
        return $this->money_amount;
    }

    public function save(){

        $user_id = $this->getUser_id();
        $card_number = $this->getCard_number();
        $money_amount = $this->getMoney_amount();
        
        $sql = "INSERT INTO credit_card VALUES(NULL,'$user_id','$card_number','$money_amount')";
        $save = $this->db->query($sql);


        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
        
    }

    public function getbyIdentity(){

        $id = $_SESSION['identity']->id;

        $sql = "SELECT * FROM credit_card WHERE user_id = '$id'";
        $credit_card = $this->db->query($sql);
        $credit_card = $credit_card->fetch_object();

        return $credit_card;
    }

    public function alreadyexistsbyIdentity(){

        $exists = false;

        $id = $_SESSION['identity']->id;

        $sql = "SELECT * FROM credit_card WHERE user_id = '$id'";
        $query = $this->db->query($sql);

        if($query && $query->num_rows != 0){

            $exists = true;

        }

        return $exists;

    }

    public function deposit($sum){

        $deposited = false;

        $id = $_SESSION['identity']->id;

        $sql = "UPDATE credit_card SET money_amount = '$sum' WHERE user_id = '$id';";
        $deposit = $this->db->query($sql);

        if($deposit){
            $deposited = true;
        }

        return $deposited;


    }

}


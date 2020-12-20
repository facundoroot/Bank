<?php 

class Transfer{

    private $id;
    private $transferer_id;
    private $transfered_to;
    private $amount;
    private $db;

    // recordar que el metodo construct se corre automaticamente cuando se crea el objeto
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setTransferer_id($transferer_id){
        $this->transferer_id = $this->db->real_escape_string($transferer_id);
    }
    public function setTransfered_to($transfered_to){
        $this->transfered_to = $this->db->real_escape_string($transfered_to);
    }
    public function setAmount($amount){
        $this->amount = $this->db->real_escape_string($amount);
    }

    public function getId(){
        return $this->id;
    }
    public function getTransferer_id(){
        return $this->transferer_id;
    }
    public function getTransfered_to(){
        return $this->transfered_to;
    }
    public function getAmount(){
        return $this->amount;
    }

    public function fundsbyId(){
        $id = $_SESSION['identity']->id;

        $sql = "SELECT * FROM credit_card WHERE user_id = '$id'";
        $query = $this->db->query($sql);

        if($query){
            $credit_card = $query->fetch_object();
        }

        return $credit_card;
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

    public function update_transfered_db($sum,$id){

        $updated = false;

        $sql = "UPDATE credit_card SET money_amount = '$sum' WHERE user_id = '$id';";
        $deposit = $this->db->query($sql);

        if($deposit){
            $updated = true;
        }

        return $updated;


    }

    public function userexistbyEmail($email){

        $exists = false;

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = $this->db->query($sql);



        if($query && $query->num_rows != 0){
            $exists = true;
        }

        return $exists;

    }

    public function save(){

        $sql = "INSERT INTO transference VALUES(NULL,'{$this->getTransferer_id()}','{$this->getTransfered_to()}','{$this->getAmount()}')";
        $save = $this->db->query($sql);

        $transfered = false;
        if($save){
            $transfered = true;
        }

        return $transfered;
    }

    public function transferExist(){

        $transference = false;

        $my_email = $_SESSION['identity']->email;

        $sql = "SELECT * FROM transference WHERE transfered_to = '$my_email'";
        $query = $this->db->query($sql);

        if($query){
            $transference = $query->fetch_object();
        }

        return $transference;
    }

    public function getAll()
    {
        $my_email = $_SESSION['identity']->email;
        $transferences = $this->db->query("SELECT * FROM transference WHERE transfered_to = '$my_email' ORDER BY id DESC;");
        return $transferences;

    }

    public function getTransfererFromId(){

        $transferer = false;

        $sql = "SELECT * FROM users WHERE id = '{$this->getTransferer_id()}'";
        $query = $this->db->query($sql);

        if($query){

            $transferer = $query->fetch_object();

        }

        return $transferer;
    }

    public function deleteTransference(){
        $delete = false;

        $my_email = $_SESSION['identity']->email;

        $sql = "DELETE FROM transference WHERE transfered_to = '$my_email'";
        $query = $this->db->query($sql);

        if($query){
            $delete = true;
        }

        return $delete;
    }

    public function deleteTransferenceById($id){
        $delete = false;

        $sql = "DELETE FROM transference WHERE id = '$id'";
        $query = $this->db->query($sql);

        if($query){
            $delete = true;
        }

        return $delete;
    }

    public function getTransferedUser(){

        $user_transfered = false;

        $email_to_transfer = $this->getTransfered_to();

        $sql = "SELECT * FROM users WHERE email = '$email_to_transfer'";
        $query = $this->db->query($sql);

        if($query){
            $user_transfered = $query->fetch_object();
        }

        return $user_transfered;
    }

    public function getTransferedCreditCard($id){

        $credit_card = false;

        $sql = "SELECT * FROM credit_card WHERE user_id = '$id'";
        $query = $this->db->query($sql);

        if($query){
            $credit_card = $query->fetch_object();
        }

        return $credit_card;
    }

}
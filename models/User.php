<?php 

class User{
    
        private $id;
        private $name;
        private $last_name;
        private $email;
        private $password;
        private $db;

    // recordar que el metodo construct se corre automaticamente cuando se crea el objeto
    public function __construct()
    {
        $this->db = Database::connect();
    }

        public function setId($id){
            $this->id = $id;
        }
        public function setName($name){
            $this->name = $this->db->real_escape_string($name);
        }
        public function setLast_name($last_name){
            $this->last_name = $this->db->real_escape_string($last_name);
        }
        public function setEmail($email){
            $this->email = $this->db->real_escape_string($email);
        }
        public function setPassword($password){
            $this->password = $password;
        }


        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function getLast_name(){
            return $this->last_name;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPassword(){
            return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
        }





        public function save(){

            // armo la query para insertar el nuevo usuario en la db
            $sql = "INSERT INTO users VALUES(NULL,'{$this->getName()}','{$this->getLast_name()}','{$this->getEmail()}','{$this->getPassword()}')";
            $save = $this->db->query($sql);

            $result = false;
            if ($save) {
                $result = true;
            }
            return $result;

        }


        public function login(){

            $result = false;
            // no uso los get y agarro directo los valores que puse con set, ya que sino me hashea la apssword
            $email = $this->email;
            $password = $this->password;

            // veo los usuarios que coinciden con el email que traigo del form
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $login = $this->db->query($sql);

            // veo si se hizo bien el query y si es una sola fila
            if($login && $login->num_rows == 1){

                // si es una sola fila traigo toda la info de la fila en forma de objeto
                $user = $login->fetch_object();

                // verificar la password
            // password_verify busca si la contrasenia($password) coincide con algun hash ($user->password)
                $verify = password_verify($password, $user->password);

                // si la verificacion es correcta o sea la password que escribio el usuario consigue con la contrasenia del usuario que tiene el mismo email en la db
                // tomo ese objeto usuario
                if($verify){
                    $result = $user;
                }

            }

            // devuelvo el objeto
            return $result;
        }






        public function alreadyExist(){

            $exists = false;

            // traigo la info
            $email = $this->getEmail();


            // miro en la db si el mail ya esta guardado
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $query = $this->db->query($sql);

            if($query->num_rows != 0){
                // si es vacio la query es por que no hay un usuario con ese email
                $exists = true;
            }

            return $exists;
        }
}
<?php
/**
 * SmartAjo
 * Class: userModel.php
 * Author: @thisisudo
 */

class userModel {

    private $db ;
    private $qry ;
    private $return = array("status"=>false,"result"=>null) ;

    /* Directory where user profile pictures are stored */
    //private $uploadsDir = 'data/images/user/' ;

    /* SQL database tables */
    private $userTable = 'sa_users' ;

    /**
     * Every model needs a database connection, passed to the model
     * Create a new instance of the database
     */
    function __construct() {
        try {
            $this->db = new Database() ;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }


    /**
     * Create a new user profile
     * @param $name
     * @param $email
     * @param $phone
     * @param $password
     * @internal param $username
     * @internal param $name
     * @internal param $sex
     * @internal param $fbid
     * @return array
     */
    public function create($name,$email,$phone,$password){
        $name = Utility::sanitizeStr( $name ) ;
        $email = Utility::sanitizeStr( $email ) ;
        $phone = Utility::sanitizeStr( $phone ) ;
        $password = Utility::createHash( Utility::sanitizeStr( $password ) ) ; // encrypt password
        /* Check if email address is available */
        if(self::checkData('email',$email) !== null){
            $this->return['result'] = "Sorry the email address ".$email." is not available" ;
        }
        else if(self::checkData('phone',$phone) !== null){
            $this->return['result'] = "Sorry the phone number ".$phone." is not available" ;
        }else{
            $code = self::newInviteCode();
            $dataSet = "code='".$code."', email='".$email."', phone='".$phone."', password='".$password."', name='".$name."'" ;
            $this->qry = $this->db->dbINSERT($dataSet,$this->userTable);
            if($this->qry->status == true){
                /* Get uid from invite code */
                $qry = $this->db->dbSELECT('uid',"code='".$code."'",$this->userTable);
                $this->return['status'] = true ;
                $this->return['result'] = array( "uid" => $qry->result->uid , "apikey" => $code );
                self::sendWelcomeEmail($email);
            }else{
                $this->return['result'] = $this->qry->result ;
            }
        }
        return $this->return;
    }


    private function sendWelcomeEmail($email){
        $email = new Email();
        $email->setSubject("Welcome To SmartAjo");
        $email->setFrom(FROM_EMAIL,FROM_EMAIL);
        $email->setTo($email,$email);
        $email->setMessage("Hi, <br> Your SmartAjo account has successfully been created.");
        $email->send();
    }


    /**
     * Update a user profile information
     * @param $uid
     * @param $name
     * @param $address
     * @internal param $email
     * @internal param $sex
     * @return array
     */
    public function updateProfile($uid,$name,$address){
        $uid = Utility::sanitizeStr( $uid ) ;
        $name = Utility::sanitizeStr( $name ) ;
        $address = Utility::sanitizeStr( $address ) ;
        $dataSet = "name='".$name."', address='".$address."', status='1'" ;
        $this->qry = $this->db->dbUPDATE($dataSet,"uid='".$uid."'",$this->userTable);
            if($this->qry->status == true){
                $this->return['status'] = true ;
            }else{
                $this->return['result'] = $this->qry->result ;
            }
        return $this->return;
    }


    /**
     * Authenticate a user login request
     * @param $login
     * @param $password
     * @internal param $email
     * @internal param $phone
     * @return array
     */
    public function authenticate($login,$password){
        $login = Utility::sanitizeStr($login);
        $password = Utility::sanitizeStr($password);
        $select = $this->db->dbSELECT('uid,password',"email='".$login."' OR phone='".$login."'",$this->userTable);
        if( $select->status == true ){
            $r = $select->result ;
            if($r->uid){
                if ( crypt($password, $r->password ) === $r->password ) {
                    $this->return['status'] = true ;
                    $this->return['result'] = array("uid"=>$r->uid) ;
                }
            }else{
                $this->return['result'] = $select->result ;
            }
        }
        return $this->return;
    }


    /**
     * Get all user data
     * @param $uid
     * @return array
     */
    public function getProfile($uid){
        $uid = Utility::sanitizeStr($uid);
        $this->qry = $this->db->dbSELECT('*',"uid='".$uid."'",$this->userTable) ;
        if($this->qry->status == true){
            $this->return['status'] = true ;
            $this->return['result'] = $this->qry->result ;
        }else{
            $this->return['result'] = $this->qry->result ;
        }
        return $this->return;
    }


    /**
     * Create a new invite code for user
     * @return string
     */
    private function newInviteCode(){
        $code = Utility::rand(5);
        return $code.Utility::rand(5);
    }


    /**
     * Check if a particular column contains
     * some specific data
     * column - value pairs
     * @param $column
     * @param $value
     * @param string $where
     * @return null
     */
    private function checkData($column,$value,$where=''){
        $this->qry = $this->db->dbSELECT($column,$column."='".$value."' $where",$this->userTable);
        if($this->qry->status == true ){
            return $value ;
        }else{
            return null ;
        }
    }

} 
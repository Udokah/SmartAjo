<?php
/**
 * smartAjo
 * Class: ajoModel.php
 * Author: @thisisudo
 * Date: 11/22/14
 * Time: 5:10 PM
 */

class ajoModel {

    private $db ;
    private $return = array("status"=>false,"result"=>null) ;

    /* Directory where user profile pictures are stored */
    //private $uploadsDir = 'data/images/user/' ;

    /* SQL database tables */
    private $ajoTable = 'sa_ajo' ;
    private $membersTable = 'sa_ajo_members';
    private $banksTable = 'sa_bank_details';

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
     * @param $uid
     * @param $name
     * @param $amount
     * @param $debit_date
     * @param $debit_account
     * @param $credit_account
     * @return array
     */
    public function create($uid,$name,$amount,$debit_date,$debit_account,$credit_account){
        $uid = Utility::sanitizeStr($uid);
        $name = Utility::sanitizeStr($name);
        $amount = Utility::sanitizeStr($amount);
        $debit_date = Utility::sanitizeStr($debit_date);
        $debit_account = Utility::sanitizeStr($debit_account);
        $credit_account = Utility::sanitizeStr($credit_account);
        $code = self::newKey();
        /* create necessary params */
        $invite = Utility::rand(10);
        $dataSet = "uid='$uid', code='".$code."', name='$name', debit_account='$debit_account', credit_account='$credit_account', amount='$amount', debit_date='$debit_date', invite='$invite'";
        $insert = $this->db->dbINSERT($dataSet,$this->ajoTable);
        if($insert->status == true){
            $this->return['status'] = true ;
            $this->return['result'] = $code ;
        }else{
            $this->return['result'] = $insert->result ;
        }
        return $this->return ;
    }


    /**
     * Delete an Ajo
     * @param $uid
     * @return ArrToObj
     */
    public function removeAjo($uid){
        $qry = $this->db->dbDELETE("uid='$uid'",$this->ajoTable);
        return $qry ;
    }


    /**
     * Add a new Ajo member
     * @param $uid
     * @param $aid
     * @return mixed
     */
    public function addMember($uid,$aid){
        $uid = Utility::sanitizeStr($uid);
        $aid = Utility::sanitizeStr($aid);
        /* check if user has been added before */
        $check = $this->db->dbSELECT('uid',"uid='$uid' AND aid='$aid'",$this->membersTable);
        if($check->status == true){
            $this->return['result'] = 'this user has already been added to this Ajo';
        }else{
            $dataSet = "uid='$uid', aid='$aid'";
            $insert = $this->db->dbINSERT($dataSet,$this->membersTable);
            if($insert->status == true){
                $this->return['status'] = true;
            }else{
                $this->return['result'] = 'unable to add user: '.$insert->result ;
            }
        }
        return $this->return;
    }


    /**
     * remove an Ajo member
     * @param $aid
     * @param $uid
     * @return ArrToObj
     */
    public function removeMember($aid,$uid){
        $delete = $this->db->dbDELETE("aid='$aid' AND uid='$uid'",$this->membersTable);
        return $delete;
    }


    /**
     * Send invitations
     * @param $aid
     * @param $emails
     * @return array
     */
    public function invite($aid,$emails){
        $array = explode(" ",$emails);
        $emails = implode(",",$array);
        /* get invite code */
        $get = $this->db->dbSELECT('invite',"aid='$aid'",$this->ajoTable);
        $link = URL . '/invite/'.$get->result->invite ;
        $message = "You have been invited to Join Ajo Smart <br>" ;
        $message .= 'To join <a href="'.$link.'">click here</a> <br>' ;
        $message .= "Regards";
        $email = new Email();
        $email->addGenericHeader("Cc",$emails);
      $email->setTo( $email , $email )
            ->setSubject("You have an Invite From SmartAjo")
            ->setMessage($message)
            ->setFrom( FROM_EMAIL , SITENAME )
            ->addMailHeader('Reply-To', FROM_EMAIL , SITENAME )
            ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
            ->addGenericHeader('X-Mailer', 'PHP/' . phpversion()) ;
        if( $email->send()){
            $this->return['status'] = true ;
            $this->return['result'] = $message ;
        }else{
            if(APP_MODE == 'Production'){
                $this->return['result'] = $email->debug();
            }
        }
        return $this->return;
    }


    /**
     * Create a new api key for user
     * @internal param $string
     * @return string
     */
    private function newKey(){
        $key =  md5(uniqid(rand(), true));
        $time = sha1(time());
        $last = crypt($key,$time);
        return $key.$time.$last;
    }


    /**
     * Add Bank Details
     * @param $uid
     * @param $title
     * @param $name
     * @param $account
     * @param $bank
     * @return array
     */
    public function newBankAccount($uid,$title,$name,$account,$bank){
        $dataSet = "uid='$uid', name='$name', title='$title' $account='$account', $bank='$bank'" ;
        $insert = $this->db->dbINSERT($dataSet,$this->banksTable);
        if($insert->status == true){
            $this->return['status'] = true ;
        }else{
            $this->return['result'] = $insert->result ;
        }
        return $this->return ;
    }


    public function getAjoInfo($uid){
        $select = $this->db->dbSELECT('*',"uid='$uid'",$this->ajoTable);
        $array = array();
        if($select->status == true ){
            $this->return['status'] = true ;
            $this->return['result'] = $select->result ;
        }
        return $this->return;
    }

} 
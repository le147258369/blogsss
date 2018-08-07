<?php
class Account_model extends CI_Model{
    private $_tablename = "account";
    public function __construct(){
        $this->load->database();
    }
    /**
     * 新增帐号
     * @param $inputData
     * @return mixed
     */
    public function add($inputData){
        //密码不可逆加密
        if(isset($inputData['acc_password']) && !empty($inputData['acc_password'])){
            $inputData['acc_password'] = $this->_encryptPasswd($inputData['acc_password']);
        }
        $this->db->insert($this -> _tablename, $inputData);
        return $this->db->insert_id();
    }

    /**
     * 编辑帐号信息
     * @param $primaryId 帐号主键
     * @param $inputData 修改信息
     * @return mixed
     */
    public function edit($primaryId,$inputData){
        //不可逆加密
        if(isset($inputData["acc_password"]))  $inputData["acc_password"] = $this->_encryptPasswd($inputData["acc_password"]);
        return $this->db->update($this -> _tablename, $inputData, array('acc_id' => $primaryId));
    }
    /**
     * 密码不可逆加密
     * @param $password
     * @return mixed
     */
    private function _encryptPasswd($password){
        $this-> load -> library('LCom');
        return $this->lcom->encryptPasswd($password);
    }

    /**
     * 驗證帳號密碼
     * @param $username 用户名
     * @param $passwd 密码
     * @return mixed
     */
    public function verify($username, $passwd){
        $query = $this->db->get_where($this -> _tablename, array('acc_username' => $username, "acc_password" => $this->_encryptPasswd($passwd)));
        $rs = $query -> row_array();
        return $rs;
    }

    /**
     * 驗證帳號密碼
     * @param $userTonke 用户Token
     * @param $passwd 密码
     * @return mixed
     */
    public function verifyForedit($userTonke, $passwd){
        $query = $this->db->get_where($this -> _tablename, array('acc_token' => $userTonke, "acc_password" => $this->_encryptPasswd($passwd)));
        $rs = $query -> row_array();
        return $rs;
    }
}
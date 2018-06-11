<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 15:37
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class UserModel extends BaseModel
{

    protected $tableName='admin_user';


    public function addUser($data){
        $user_info=$this->data($data)->add();
        if($user_info){
            $user_name=array(
                'user_name'=>$data['user_name'],
                'type'=>4,
                'status'=> parent::NORMAL_STATUS,
                'user_id'=>$user_info
            );
            $info=D('UserName')->data($user_name)->add();
            if ($info){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    public function checkUser($user_name)
    {
        return $this->where('user_name='.$user_name)->find()?false:true;
    }


    public function forgetPassword($user_id){
        $where=array(
            'id'=>$user_id
        );
        $returnData=mt_rand(00000000,99999999);
        $saveData=array(
            'password'=>md5($returnData),
        );
        $pwd_info=$this->where($where)->save($saveData);
        if($pwd_info){
            return $returnData;
        }else{
            return 0;
        }
    }

    public function findUser($name,$pwd){
        $uid=D('UserName')->getUserId($name);
        $where = array(
            'id' => $uid,
            'password' => $pwd,
            'status'   => parent::NORMAL_STATUS,
        );

        $result = $this->where($where)->find();

        return $result;
    }

    /**
     * 根据id更新用户登录时间
     * @author pfq1990 <pfq1990@126.com> (2018/06/10)
     * @param unknown $id
     */
    public function updateLoginTime($id)
    {
        $where = array(
            'id' => $id,
        );
        $saveData = array(
            'lastlogin_time' => time(),
        );
        return $this->where($where)->save($saveData);
    }

}
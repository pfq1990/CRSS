<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 21:04
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class SMSCodeModel extends BaseModel
{

    protected $tableName='crs_sms_code';



    public function create_code($phone_number){
        $mail_add=$phone_number.'@qq.com';
        $data=array(
            'phone_number'=>$mail_add,
        );
        $this->where($data)->delete();
        $data['code']=mt_rand(000000,999999);
        $data['use_time']=time()+6000;
        $code_info=$this->data($data)->add();
        if($code_info){
            $code='验证码为：';
            $code.= $data['code'];
            $code.=',十分钟有效！';
            $info=sendMail($mail_add,'验证码',$code);
            if ($info){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }



    public function check_code($phone_number,$code){
        $where=array(
            'phone_number'=>$phone_number,
            'code'=>$code,
        );
        $code_info=$this->where($where)->find();
        $curr_time=time();
        if($code_info){
            if($code_info['use_time']<$curr_time){
                return false;
            }else{
                return true;
            }
            $this->where($code_info)->delete();
        }else{
            return false;
        }
    }



}
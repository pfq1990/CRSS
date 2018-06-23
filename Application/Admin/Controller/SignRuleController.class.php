<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/23
 * Time: 16:36
 */

namespace Admin\Controller;


class SignRuleController extends CommonController
{

    protected $sign_rule_moel;
    protected $user_org_model;

    public function __construct()
    {
        parent::__construct();
        $this->sign_rule_moel=D('Home/SignonRule');
        $this->user_org_model=D('Home/UserOrganization');
    }

    public function index(){
        $user_info=session('user_info');
        $oidlist=$this->user_org_model->get_user_oid_by_id($user_info['id']);
        $list=$this->sign_rule_moel->getSignonRuleList($oidlist);
        $this->assign("signonrule",$list['list']);
        $this->assign('page',$list['page']);
        $this->display();
    }

    /**
     * 添加考勤规则
     */
    public function add(){
        if(IS_POST){

            $data = I('post.');

            $where=array(
                'oid'=>$data['oid']
            );
            if ($this->sign_rule_moel->where($where)->find()){
                $this->ajaxError('该学校已有考勤规则无需再添加');
            }

            if($this->sign_rule_moel->data($data)->add()){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $where=array(
                'level'=>0,
                'status'=>1,
            );
            $orgnaization=D('Organization')->where($where)->select();
            $this->assign("orgnaization",$orgnaization);
            $this->display();
        }
    }
    public function edit(){
        if(IS_POST){
            $data = I('post.');


            $where=array(
                'id'=>$data['id']
            );
            unset($data['id']);
            $result = $this->sign_rule_moel->where($where)->save($data);
            if($result !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');

            $info=$this->sign_rule_moel->find($id);
            $this->assign('signrule',$info);
            $this->display();
        }
    }
    public function delete(){
        $id = I('post.id','','intval');

        $result = $this->sign_rule_moel->delete($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}
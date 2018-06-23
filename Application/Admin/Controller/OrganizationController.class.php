<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/26
 * Time: 8:29
 */

namespace Admin\Controller;


use Think\Controller;

class OrganizationController extends CommonController
{

    protected $organization_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $organization_model \Admin\Model\OrganizationModel */

        $organization_model = D('Organization');

        $this->organization_model = $organization_model;
    }

    public function index(){
        $organization = $this->organization_model->selectAllOrganization();
        $returnData = get_column($organization['list']);
        $this->assign("organization",$returnData);
        $this->assign('page',$organization['page']);
        $this->display();
    }

    public function add(){

        if(IS_POST){

            $user_info = session('user_info');
            $organization = array(
                'pid'      => I('post.pid','','trim'),
                'title'       => I('post.title','','trim'),
            );

            if($this->organization_model->where($organization)->find()){
                $this->ajaxSuccess('该组织已经存在');
            }

            $organization['create_id']= $user_info['id'];

            if($this->organization_model->saveNewOrganization($organization)){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $id = I('get.id','','intval');
            $this->assign('id',$id);
            $this->display();
        }

    }

    public function edit(){
        if(IS_POST){
            $data = I('post.');


            if($this->organization_model->isExistOrg($data['title'], $data['pid'],$data['id'])){
                $this->ajaxerror("该组织已存在");
            }

            $result = $this->organization_model->editOrganization($data);
            if($result !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');

            $organization_info = $this->organization_model->getOrganizationById($id);

            $this->assign('organization',$organization_info);
            $this->display();
        }
    }

    public function delete(){
        $id = I('post.id','','intval');

        if($this->organization_model->isExistSonOrg($id)){
            $this->ajaxError('存在子项未删除');
        }

        if(!$this->organization_model->deleteOrg($id)){
            $this->ajaxError('删除失败');
        }else{
            $this->ajaxSuccess('删除成功');
        }
    }

    public function getAllOrg(){
        $organization=D('Organization')->field('id,title as name,pid')->select();
        $organization=get_tree_list($organization);
        $this->ajaxReturn($organization);
    }

}
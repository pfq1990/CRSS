<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/26
 * Time: 9:06
 */

namespace Admin\Controller;


use Think\Controller;

class TeachingPlaceController extends CommonController
{

    protected $teachingPlace_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $organization_model \Admin\Model\TeachingPlaceModel */

        $teachingPlace_model = D('TeachingPlace');

        $this->teachingPlace_model = $teachingPlace_model;
    }

    public function index(){
        $teachingPlace = $this->teachingPlace_model->selectAllPlace();
        $this->assign("teachingPlace",$teachingPlace['list']);
        $this->assign('page',$teachingPlace['page']);
        $this->display();
    }

    public function delete(){
        $id = I('post.id','','intval');

        $result = $this->teachingPlace_model->delete($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

}
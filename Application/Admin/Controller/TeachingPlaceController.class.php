<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/26
 * Time: 9:06
 */

namespace Admin\Controller;


use Think\Controller;

class TeachingPlaceController extends Controller
{

    protected $teachingPlace_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $organization_model \Admin\Model\OrganizationMenuModel */

        $teachingPlace_model = D('TeachingPlace');

        $this->teachingPlace_model = $teachingPlace_model;
    }

    public function index(){
        $teachingPlace = $this->teachingPlace_model->selectAllPlace();
        //$this->assign("teachingPlace",$teachingPlace);
        $this->ajaxReturn(array('teachingPlace'=>$teachingPlace));
    }

}
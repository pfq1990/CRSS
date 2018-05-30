<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/26
 * Time: 8:29
 */

namespace Admin\Controller;


use Think\Controller;

class OrganizationController extends Controller
{

    protected $organization_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $organization_model \Admin\Model\OrganizationMenuModel */

        $organization_model = D('Organization');

        $this->organization_model = $organization_model;
    }

    public function index(){
        $organization = $this->organization_model->selectAllOrganization();
        $organization = get_column($organization);
        //$this->assign("organization",$organization);
        $this->ajaxReturn(array('organization'=>$organization));
    }

}
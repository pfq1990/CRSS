<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/8
 * Time: 21:39
 */

namespace Admin\Controller;



class DictionaryController extends CommonController
{
    protected $crs_dictionary_model;

    public function __construct(){
        parent::__construct();

        $crs_dictionary_model=D('Home/CrsDictionaryData');
        $this->crs_dictionary_model=$crs_dictionary_model;
    }

    public function index(){
        $user_info=session('user_info');
        $dictionary=$this->crs_dictionary_model->getDictionaryDataList($user_info['id']);
        $this->assign('page',$dictionary['page']);
        $this->assign('list', $dictionary['list']);
        $this->assign('default',$dictionary['default']);
        $this->display();
    }

}
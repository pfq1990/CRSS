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

        $crs_dictionary_model=D('CrsDictionaryData');
        $this->crs_dictionary_model=$crs_dictionary_model;
    }
}
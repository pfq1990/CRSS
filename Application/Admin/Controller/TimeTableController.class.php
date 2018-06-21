<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 22:26
 */

namespace Admin\Controller;


class TimeTableController extends CommonController
{

    protected $time_table_modle;

    public function __construct()
    {
        parent::__construct();
        /* @var $organization_model \Admin\Model\TimeTableModel */

        $time_table_model = D('TimeTable');

        $this->time_table_modle = $time_table_model;
    }

    public function index(){
        $timetable = $this->time_table_modle->selectAllTimeTable();
        $this->assign("timetable",$timetable['list']);
        $this->assign('page',$timetable['page']);
        $this->display();
    }

}
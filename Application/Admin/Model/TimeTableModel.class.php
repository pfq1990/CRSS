<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:56
 * 作息时间表
 */

namespace Admin\Model;


class TimeTableModel extends BaseModel
{

    protected $tableName="crs_time_table";


    public function getTimeTable($oid){
        $where=array(
            'a.oid'=>$oid
        );
        $join = 'LEFT JOIN crs_organization b ON b.id=a.oid';
        $field='a.id,a.title,a.start_time,a.end_time,a.perior_of_time,a.period,b.id as oid,b.title as oname';
        $order='a.oid asc ,a.perior_of_time asc';
        return $this->alias('a')->where($where)->field($field)->order($order)->join($join)->select();
    }

    /**
     * @description
     * @author  pfq1990
     * @return array;
     */
    public function selectAllTimeTable($num=10)
    {
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );
        $count      = $this->where($where)->count();
        $join = 'LEFT JOIN crs_organization b ON b.id=a.oid';
        $field='a.id,a.title,a.start_time,a.end_time,a.perior_of_time,a.period,b.id as oid,b.title as oname';
        $order='a.oid asc ,a.perior_of_time asc';

        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->alias('a')->where($where)->field($field)->order($order)->join($join)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

    }

}
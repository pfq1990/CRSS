<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:55
 * 学期信息表
 */

namespace Admin\Model;


class TermInfoModel extends BaseModel
{

    protected $tableName="crs_term_info";

    public function getFirstDate($oid){
        $year=date("Y",time());
        $line_start=strtotime($year."-02-26");
        $line_end=strtotime($year."-08-25");
        $today=time();
        if($today>$line_start && $today<$line_end){
            $where=array(
                'school_year'=>($year-1).'-'.$year,
                'term'=>2
            );
        }else{
            $where=array(
                'school_year'=>($year).'-'.($year+1),
                'term'=>1
            );
        }
        $where['oid']=$oid;
        $info=$this->where($where)->find();
        return $info['date'];
    }

}
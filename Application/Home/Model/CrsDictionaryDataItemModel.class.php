<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/8
 * Time: 21:07
 * 数据字典项表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class CrsDictionaryDataItemModel extends BaseModel
{

    protected $tableName="crs_dictionary_item";

    public function getUserDictionaryList($id,$num=10){
        $where=array(
            'dictionary_id'=>$id,
        );

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

    }

}
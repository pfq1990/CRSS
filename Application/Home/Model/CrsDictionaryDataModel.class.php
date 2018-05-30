<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/8
 * Time: 21:04
 * 数据字典主表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class CrsDictionaryDataModel extends BaseModel
{

    protected $tableName="crs_dictionary";

    public function getDictionaryDataList($uid,$num=10){
        $where=array(
            'user_id'=>$uid,
        );
        $data=$this->where($where)->find();
        $list=D('CrsDictionaryDataItem')->getUserDictionaryList($data['id'],$num);
        return array('page'=>$list['page'],'list'=>$list['list'],'default'=>$data['value']);
    }

}
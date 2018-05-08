<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/8
 * Time: 21:04
 */

namespace Admin\Model;


class CrsDictionaryDataModel extends BaseModel
{

    protected $tableName="crs_dictionary";

    public function getDictionaryDataList($uid,$num){
        $where=array(
            'user_id'=>$uid,
        );
        $data=$this->where($where)->find();
        $list=D('CrsDictionaryDataItem')->getUserDictionaryList($data['id'],$data['value'],$num);
        return array($list,'default'=>$data['value']);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/26
 * Time: 8:21
 * 组织结构表
 */

namespace Admin\Model;


class OrganizationModel extends BaseModel
{

    protected $tableName = 'crs_organization';

    /**
     * @description
     * @author  pfq1990
     * @return array;
     */
    public function selectAllOrganization($num=10)
    {
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

    }

    public function getAllOid($id){
        $returnStr='';
        $returnStr.=$id;
        $where=array(
            'id'=>$id,
        );
        $level=3;
        while ($level){
            $info=$this->where($where)->find();
            $level=$info['level'];
            if ($info['pid'])$returnStr.=','.$info['pid'];
            $where=array(
                'id'=>$info['pid'],
            );
        }
        return $returnStr;
    }

    public function getRootOid($id){
        $returnid=$id;
        $where=array(
            'id'=>$id,
        );
        $level=3;
        while ($level){
            $info=$this->where($where)->find();
            $level=$info['level'];
            if ($info['pid']){
                $returnid=$info['pid'];
                $where=array(
                    'id'=>$info['pid'],
                );
            }

        }
        return $returnid;
    }

    public function getOrganizationName($id){
        $where=array(
            'id'=>$id
        );
        $data=$this->where($where)->find();
        return $data['title'];
    }

    public function saveNewOrganization($data){

        if(empty($data['level'])&&$data['pid']){
            $where=array(
                'id'=>$data['pid']
            );
            $info=$this->where($where)->find();
            $data['level']=$info['level']+1;
        }

        $data['status']=parent::NORMAL_STATUS;
        return $this->data($data)->add();
    }

}
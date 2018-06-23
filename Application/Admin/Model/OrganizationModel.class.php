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

    /**
     * 获取所有能查询到课程的id
     * @param $id
     * @return string
     */
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

    /**
     * 获取id指示的学校id
     * @param $id
     * @return mixed
     */
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

    /**
     * 获取组织名称
     * @param $id
     * @return mixed
     */
    public function getOrganizationName($id){
        $where=array(
            'id'=>$id
        );
        $data=$this->where($where)->find();
        return $data['title'];
    }

    /**
     * 添加组织
     * @param $data
     * @return mixed
     */
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

    /**
     * 判断组织是否已经添加
     * @param $name
     * @param $pid
     * @param null $id
     * @return mixed
     */
    public function isExistOrg($name,$pid,$id=null){
        $where=array(
            'title'=>$name,
            'pid'=>$pid,
            'status'=>parent::NORMAL_STATUS
        );
        if($id){
            $where['id'] = array('neq',$id);
        }
        return $this->where($where)->find();
    }

    /**
     * 修改组织信息
     * @param $data
     * @return bool|\Think\Model
     */
    public function editOrganization($data){
        $where=array(
            'id'=>$data['id']
        );
        unset($data['id']);
        return $this->where($where)-$this->save($data);
    }

    /**
     * 获取组织信息
     * @param $id
     * @return mixed
     */
    public function getOrganizationById($id){
        $where=array(
            'id'=>$id
        );
        $data=$this->where($where)->find();
        return $data;
    }

    /**
     * 检查是否存在子项
     * @param $id
     * @return mixed
     */
    public function isExistSonOrg($id){
        $where = array(
            'pid' => $id,
            'status' => parent::NORMAL_STATUS,
        );

        return $this->where($where)->find();
    }

    /**
     * @description:删除
     * @author wuyanwen(2016年12月1日)
     * @param unknown $id
     */
    public function deleteOrg($id)
    {
        $where = array(
            'id' => $id,
        );

        /*
        $data = array(
            'status' => parent::DEL_STATUS,
        );

        return $this->where($where)->save($data);
        */
        return $this->where($where)->delete();
    }


    /**
     * 获取和该学校所有相关的oid
     * @param $id
     * @return string
     */
    public function getAllSonId($id){
        $str='';
        $str.=$id;
        $where=array(
            'pid'=>$id,
        );
        while ($info=$this->where($where)->field('id')->select()){
            $tmp='';
            foreach ($info as $key => $value){
                $tmp.=$value['id'];
                if($info[$key+1])$tmp.=',';
            }
            $where['pid']=array('in',$tmp);
            $str.=','.$tmp;
        }
        return $str;
    }

}
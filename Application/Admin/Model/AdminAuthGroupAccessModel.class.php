<?php
namespace Admin\Model;

class AdminAuthGroupAccessModel extends BaseModel
{
    protected $tableName = 'admin_auth_group_access';
    
    /**
     * 获取用户所有权限
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/02)
     */
    public function getUserRules($user_id)
    {
        
        $where = array(
            'a.uid' => $user_id,
        );
        $join = 'LEFT JOIN admin_auth_group b ON b.id=a.group_id';
        $rules = $this->alias('a')
                      ->where($where)
                      ->join($join)
                      ->field('b.rules')
                      ->select();
       
        if(!$rules){
            return array();
        }
        
        $rules_str = '';
        foreach($rules as $v){
            $rules_str .= $v['rules'] . ',';
        }
        
        $rules_str = rtrim($rules_str, ',');

        $rules_arr = array_unique(explode(',', $rules_str));
        
        $admin_menu_model = new AdminMenuModel();
        $menus = $admin_menu_model->getMenus($rules_arr);
        
      
        $menus = get_column($menus, 2);
        
        //dump($menus);exit;
        return $menus;
        
    }

    public function getUserGroup($user_id,$group_id)
    {
        $where = array(
            'uid' => $user_id,
            'group_id'=>array('neq',$group_id),
        );
        $result = $this->where($where)->field('group_id')->select();
        return $result;
    }

}
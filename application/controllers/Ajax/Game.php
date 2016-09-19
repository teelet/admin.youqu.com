<?php
/**
 * ajax获取游戏信息
 * User: shaohua5
 * Date: 16/9/18
 * Time: 下午2:34
 */

class Ajax_GameController extends AbstractController {

    /*
     * 获取游戏下的角色
     */
    public function getGameRolesAction(){
        $this->data['gid'] = Comm_Context::param('gid', 0); //游戏id
        //获取游戏角色
        $roles = Game_GameModel::getGameRoles($this->data['gid']);
        $this->data['result'] = '';
        if($roles){
            $this->data['result'] .= '<option value="">请选择</option>';
            foreach($roles as $role){
                $this->data['result'] .= '<option value="'.$role['rid'].'">'.$role['name'].'</option>';
            }
        }
        $this->jsonResult();
        return $this->end();
    }
}
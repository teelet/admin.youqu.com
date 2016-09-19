<?php
/**
 * 内容管理
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:07
 */

class ContentmanageController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        //判断用户是否登录
        $this->isLogin();
        $this->tpl = 'contentManage.phtml'; //试图页面
        //获取查询参数
        $this->data['page'] = Comm_Context::param('page', 1); //当前页
        $this->data['gid'] = Comm_Context::param('gid', 0); //游戏id
        $this->data['rid'] = Comm_Context::param('rid', 0); //角色id
        $this->data['a_t_id'] = Comm_Context::param('a_t_id', 0); //类型id
        $this->data['a_f_id'] = Comm_Context::param('a_f_id', 0); //形式id
        //调用接口获取查询结果
        $res = Article_ArticleModel::getArticleList($this->data['gid'], $this->data['rid'], $this->data['a_t_id'], $this->data['a_f_id'], $this->data['page'], 10);
        $this->data['article_list'] = $res['result']['lists'];
        //总页数
        $this->data['pageCount'] = $res['result']['pageCount'];
        //获取游戏列表
        if($this->data['gid']){
            $this->data['roles'] = Game_GameModel::getGameRoles($this->data['gid']);
        }
        //获取游戏列表
        $this->data['game_list'] = Game_GameModel::getGameList();
        //获取内容类型
        $this->data['article_types'] = Article_ArticleModel::getArticleTypes();
        //获取内容形式
        $this->data['article_forms'] = Article_ArticleModel::getArticleForms();
        //渲染
        $this->assign();
        return $this->end();
    }
}

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
        /*
        $this->data = array(); //试图页数据
        $get = $this->getRequest()->getQuery("name", "aaa"); //获取参数
        $this->data['name'] = $get;
        */
        //渲染
        $this->assign();
        return $this->end();
    }
}

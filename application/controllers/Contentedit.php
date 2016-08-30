<?php
/**
 * 文章修改
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:17
 */

class ContenteditController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'contentEdit.phtml'; //试图页面
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
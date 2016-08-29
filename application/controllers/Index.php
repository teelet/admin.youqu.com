<?php
/**
 * @name IndexController
 * @desc 默认控制器
 */

class IndexController extends AbstractController {

	/** 
     * 默认动作
     */
    
	public function indexAction() {
	    $this->tpl = 'main.phtml'; //试图页面
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

<?php
/**
 * 添加内容
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:11
 */

class AddarticleController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'addArticle.phtml'; //试图页面
        if(empty($this->data['ret'])){
            $this->data['ret'] = "无返回信息";
        }
        /*
        $this->data = array(); //试图页数据
        $get = $this->getRequest()->getQuery("name", "aaa"); //获取参数
        $this->data['name'] = $get;
        */
        //渲染
        $this->assign();
        return $this->end();
    }

    /**
     * 处理函数
     */
    public function handlerAction(){
        $url = $this->data["url"] = Comm_Context::form("content_url","");
        $data = array(
            "field1"=>"value1",
            "field2"=>"value2",
        );
        $method = 'GET';
        $http = new Comm_HttpRequest();
        $http->url = $url;
        $http->set_method($method);
        foreach ($data as $k => $v){
            $http->add_query_field($k, $v);
        }
        $http->set_timeout(5000);
        $http->set_connect_timeout(5000);
        $http->send();
        $ret = $http->get_response_content();
        $ret = trim($ret);
        $this->data["ret"] = ($ret != "") ? $ret : "无返回信息";
        $this->indexAction();
        return $this->end();
    }
}

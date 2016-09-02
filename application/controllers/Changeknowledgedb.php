<?php
/**
 * 更新知识库
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:09
 */

class ChangeknowledgedbController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'changeKnowledgeDb.phtml'; //试图页面
        if(empty($this->data['ret'])){
            $this->data['ret'] = "无返回信息";
        }
        //渲染
        $this->assign();
        return $this->end();
    }

    /**
     * 提交更新
     */
    public function updateAction(){
        $data = array(
            "field1"=>"value1",
            "field2"=>"value2",
        );
        // $url = "http://i.youqu.intra.weibo.com/game_recommend";
        $url = "http://123.206.44.28";
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

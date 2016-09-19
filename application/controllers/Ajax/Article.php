<?php
/**
 * ajax 操作aritcle
 * User: shaohua5
 * Date: 16/9/18
 * Time: 下午4:16
 */

class Ajax_ArticleController extends AbstractController {

    /*
     * 文章上线,下线
     */
    public function setArticleStatusAction(){
        $this->data['aid'] = Comm_Context::form('aid', 0);
        $this->data['type'] = Comm_Context::form('type', 0); //0：上线 1：下线
        $res = Article_ArticleModel::setArticleStatus($this->data['aid'], $this->data['type']);
        if($res['code'] == 0){
            $this->data['status'] = 0;
            $this->data['result'] = "操作成功";
        }else{
            $this->data['status'] = 1;
            $this->data['result'] = "操作失败";
        }
        $this->jsonResult();
        return $this->end();
    }

    /*
     * 修改文章内容
     */
    public function updateContentAction(){
        $this->data['aid'] = Comm_Context::form('aid', 0);
        $this->data['json'] = Comm_Context::form('json');
        $res = Article_ArticleModel::updateArticleContent($this->data['aid'], $this->data['json']);
        // 写操作log, 不在意log是否写成功
        $article = Article_ArticleModel::getArticleContent($this->data['aid']);
        $resWriteLog = Comm_Log::writeLog("修改文章，文章aid：".$this->data['aid']."，标题：".$article["result"]["title"]);
        if($res['code'] == 0){
            $this->data['status'] = 0;
            $this->data['result'] = "操作成功";
        }else{
            $this->data['status'] = 1;
            $this->data['result'] = "操作失败";
        }
        $this->jsonResult();
        return $this->end();
    }
}
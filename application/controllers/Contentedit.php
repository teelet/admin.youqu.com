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
        //判断用户是否登录
        $this->isLogin();
        $this->tpl = 'contentEdit.phtml'; //试图页面
        $this->data['aid'] = Comm_Context::param('aid', 0);
        //获取文章内容
        $article = Article_ArticleModel::getArticleContent($this->data['aid']);
        
        $this->data['article'] = $article['result'];
        //获取内容类型
        $this->data['article_types'] = Article_ArticleModel::getArticleTypes();
        //获取内容形式
        $this->data['article_forms'] = Article_ArticleModel::getArticleForms();
        //获取文章标签
        
        //渲染
        $this->assign();
        return $this->end();
    }
}
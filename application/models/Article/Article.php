<?php
/**
 * 操作文章
 * User: shaohua5
 * Date: 16/9/18
 * Time: 上午10:48
 */
class Article_ArticleModel {

    const db = 'gameinfo';

    /*
     * 获取内容类型
     */
    public static function getArticleTypes(){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $articleTypes = $instance->select('article_type', array('a_t_id', 'name'));
        return $articleTypes;
    }

    /*
     * 获取内容形式
     */
    public static function getArticleForms(){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $articleForms = $instance->select('article_form', array('a_f_id', 'name'));
        return $articleForms;
    }

    /*
     * 通过条件查询文章
     * gid 游戏id
     * rid 角色id
     * a_t_id 文章类型id
     * a_f_id 文章形式id
     */
    public static function getArticleList($gid = 0, $rid = 0, $a_t_id = 0, $a_f_id = 0, $page = 1, $pageSize = 10){
        $url = Comm_Config::getPhpConf('interface.get_article_list');
        $http = new Comm_HttpRequest();
        $http->url = $url;
        $http->set_method('GET');
        if($gid){
            $http->add_query_field('gid', $gid);
        }
        if($rid){
            $http->add_query_field('tag_id', $rid);
        }
        if($a_t_id){
            $http->add_query_field('a_t_id', $a_t_id);
        }
        if($a_f_id){
            $http->add_query_field('a_f_id', $a_f_id);
        }
        $http->add_query_field('page', $page);
        $http->add_query_field('num', $pageSize);
        $http->set_timeout(5000);
        $http->set_connect_timeout(5000);
        $http->send();
        $res = $http->get_response_content();
        return json_decode($res, true);
    }

    /*
     * 更新文章内容
     * aid
     * content 数组
     */
    public static function updateArticleContent($aid, $content){
        if(empty($aid) || empty($content)){
            return false;
        }
        $url = Comm_Config::getPhpConf('interface.update_article_content');
        $http = new Comm_HttpRequest();
        $http->url = $url;
        $http->set_method('POST');
        //$http->set_header(array("content-type: application/x-www-form-urlencoded; charset=UTF-8"));
        $http->add_query_field('aid', $aid);
        $http->add_query_field('json', json_encode($content));
        $http->set_timeout(5000);
        $http->set_connect_timeout(5000);
        $http->send();
        $res = $http->get_response_content();
        return json_decode($res, true);
    }

    /*
     * 文章上下线
     * aid 文章id
     * type 0：上线 1：下线
     */
    public static function setArticleStatus($aid = 0, $type = 0){
        $url = Comm_Config::getPhpConf('interface.down_article');
        $http = new Comm_HttpRequest();
        $http->url = $url;
        $http->set_method('POST');
        $http->add_query_field('aid', $aid);
        $http->add_query_field('type', $type);
        $http->set_timeout(5000);
        $http->set_connect_timeout(5000);
        $http->send();
        $res = $http->get_response_content();
        return json_decode($res, true);
    }

    /*
     * 获取文章内容
     * aid 文章id
     */
    public static function getArticleContent($aid){
        $url = sprintf(Comm_Config::getPhpConf('interface.get_article_content'), $aid);
        $http = new Comm_HttpRequest();
        $http->url = $url;
        $http->set_method('GET');
        $http->set_timeout(5000);
        $http->set_connect_timeout(5000);
        $http->send();
        $res = $http->get_response_content();
        return json_decode($res, true);
    }
}

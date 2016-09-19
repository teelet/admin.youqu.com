<?php
/**
 * 接口列表
 * User: shaohua5
 * Date: 16/9/18
 * Time: 上午11:14
 */
return array(
    //上线将host改成 api.playerfun.cn
    'get_article_list' => 'http://testapi.playerfun.cn/article/get_article_list.json',
    'down_article' => 'http://testapi.playerfun.cn/article/down_article.json',
    'get_article_content' => 'http://testapi.playerfun.cn/article/%s.json',  //占位符:文章id,如http://testapi.playerfun.cn/article/1189.json
    'update_article_content' => 'http://testapi.playerfun.cn/article/update_base.json',
);

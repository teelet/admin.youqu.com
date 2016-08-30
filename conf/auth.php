<?php

/**
 * 权限配置文件
 * shaohao
 */

return array(

    'salt' => 'youqu_salt', //用户密码盐值

    'class' => array( // 类目
        '1000' => '内容管理',
        '1001' => '其他操作',
        '1002' => '权限管理'
    ),

    'auth' => array( // 权限
        '0001' => array(
            'authName' => '内容管理',
            'classId'  => '1000',
            'url'      => '/contentManage'
        ),
        '0002' => array(
            'authName' => '更新知识库',
            'classId'  => '1001',
            'url'      => '/changeKnowledgeDb'
        ),
        '0003' => array(
            'authName' => '添加内容',
            'classId'  => '1001',
            'url'      => '/addArticle'
        ),
        '0004' => array(
            'authName' => '添加标签',
            'classId'  => '1001',
            'url'      => '/addTag'
        ),
        '0005' => array(
            'authName' => '添加别名',
            'classId'  => '1001',
            'url'      => '/addAlias'
        ),
        '0006' => array(
            'authName' => '权限管理',
            'classId'  => '1002',
            'url'      => '/authManage'
        )
    )

);


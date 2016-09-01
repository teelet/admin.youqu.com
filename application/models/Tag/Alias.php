<?php
class Tag_AliasModel {
	const db = 'gameinfo';
	
	/**
	 * 查询别名列表
	 *
	 * @param unknown $level        	
	 * @return unknown
	 */
	public static function getAliasListByTid($tid) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.read' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$alias_list = $instance->select ( 'alias', array (
				'id',
				'tid',
				'alias' 
		), array (
				'tid' => $tid 
		), array (
				'ORDER' => 'atime desc' 
		) );
		$new_alias_list = array ();
		for($i = 1; $i <= count ( $alias_list ); $i ++) {
			$new_alias_list [] = "别名{$i}:" . $alias_list [$i - 1] ['alias'];
		}
		
		return implode ( "		", $new_alias_list );
	}
	/**
	 * 添加别名
	 *
	 * @param unknown $tid        	
	 * @param unknown $alias_name        	
	 * @return string
	 */
	public static function insertAlias($tag, $alias_name) {
		// 连接数据库
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.write' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$ret = $instance->insert ( 'alias', array (
				'tid' => $tag ['tid'],
				'display_name' => $tag ['name'],
				'alias' => $alias_name 
		) );
		return $ret;
	}
}
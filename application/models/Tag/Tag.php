<?php
class Tag_TagModel {
	const db = 'gameinfo';
	
	/**
	 * 根据标签id获取标签详情
	 *
	 * @param unknown $tid        	
	 */
	public static function getTagByTid($tid) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.read' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$tag = $instance->select ( 'tag', array (
				'tid',
				'name',
				'gid',
				'level',
				'type' 
		), array (
				'tid' => $tid 
		) );
		return $tag [0];
	}
	/**
	 * 插入新的标签
	 *
	 * @param unknown $parent_tag_id        	
	 * @param unknown $tag_name        	
	 * @param unknown $tag_level        	
	 */
	public static function insertTag($tag_name, $tag_level, $gid, $type) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.write' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$ret = $instance->insert ( 'tag', array (
				'name' => $tag_name,
				'gid' => $gid,
				'level' => $tag_level,
				'type' => $type 
		) );
		return $ret;
	}
	/**
	 * 根据标签的级别查询标签列表，按时间递减
	 *
	 * @param unknown $level        	
	 * @return unknown
	 */
	public static function getTagListByLevel($level) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.read' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$tag_list = $instance->select ( 'tag', array (
				'tid',
				'name',
				'gid',
				'level',
				'type' 
		), array (
				'level' => $level 
		), array (
				'ORDER' => 'atime desc' 
		) );
		return $tag_list;
	}
	/**
	 * 根据标签的级别和一级标签id查询标签列表，按时间递减
	 *
	 * @param unknown $level        	
	 * @return unknown
	 */
	public static function getTagListByGid($level, $gid) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.read' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$tag_list = $instance->select ( 'tag', array (
				'tid',
				'name',
				'gid',
				'level',
				'type' 
		), array (
				'and' => array (
						'gid' => $gid,
						'level' => $level 
				) 
		), array (
				'ORDER' => 'atime desc' 
		) );
		return $tag_list;
	}
	/**
	 * 根据标签的级别和二级标签id查询标签列表，按时间递减
	 *
	 * @param unknown $level
	 * @return unknown
	 */
	public static function getTagListByType($level, $type) {
		// 获取数据库配置文件
		$config = Comm_Config::getPhpConf ( 'db/db.' . self::db . '.read' );
		$instance = Comm_Db_Handler::getInstance ( self::db, $config );
		$tag_list = $instance->select ( 'tag', array (
				'tid',
				'name',
				'gid',
				'level',
				'type'
		), array (
				'and' => array (
						'type' => $type,
						'level' => $level
				)
		), array (
				'ORDER' => 'atime desc'
		) );
		return $tag_list;
	}
	/**
	 * 获取标签级别列表
	 *
	 * @return multitype:string
	 */
	public static function getLevelList() {
		$level_list = array (
				'1' => '一级标签',
				'2' => '二级标签',
				'3' => '三级标签' 
		);
		return $level_list;
	}
	/**
	 * 将tag列表封装成option格式
	 *
	 * @param unknown $tag_list        	
	 */
	public static function getTagSelectOptions($tag_list) {
		$ret = "<option value='0'>请选择</option>";
		foreach ( $tag_list as $val ) {
			$ret .= "<option value='{$val['tid']}'>{$val['name']}</option>";
		}
		return $ret;
	}
	/**
	 * 查询别名列表
	 *
	 * @return multitype:
	 */
	public static function addAliasIndex() {
		// 查询一级标签列表
		$level1_list = Tag_TagModel::getTagListByLevel ( 1 );
		// 查询二级标签列表
		$level2_list = Tag_TagModel::getTagListByLevel ( 2 );
		// 查询三级标签列表
		$level3_list = Tag_TagModel::getTagListByLevel ( 3 );
		// 将三级标签列表封装成层级关系
		return Tag_TagModel::trans2level ( $level1_list, $level2_list, $level3_list );
	}
}
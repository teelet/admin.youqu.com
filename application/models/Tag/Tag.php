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
	 * 将三个级别的标签合并成层级关系的列表
	 *
	 * @param unknown $leve1_list        	
	 * @param unknown $level2_list        	
	 * @param unknown $level3_list        	
	 */
	public static function trans2level($level1_list, $level2_list, $level3_list) {
		$new_level1_list = array (
				array (
						'v' => 0,
						'n' => '选择游戏',
						's' => array (
								array (
										'v' => 0,
										'n' => '选择二级标签',
										's' => array (
												array (
														'v' => 0,
														'n' => '选择具体标签' 
												) 
										) 
								) 
						) 
				) 
		);
		foreach ( $level1_list as $v ) {
			$new_level1_list [$v ['tid']] = array (
					'v' => $v ['tid'],
					'n' => $v ['name'],
					'level' => $v ['level'],
					'up_level' => $v ['gid'],
					's' => array (
							array (
									'v' => 0,
									'n' => '选择二级标签',
									's' => array (
											array (
													'v' => 0,
													'n' => '选择具体标签' 
											) 
									) 
							) 
					) 
			);
		}
		// if (empty ( $level2_list ))
		// return array_values ( $new_level1_list );
		$new_level2_list = array ();
		foreach ( $level2_list as $v ) {
			$new_level2_list [$v ['tid']] = array (
					'v' => $v ['tid'],
					'n' => $v ['name'],
					'level' => $v ['level'],
					'up_level' => $v ['gid'],
					's' => array (
							array (
									'v' => 0,
									'n' => '选择具体标签' 
							) 
					) 
			);
		}
		foreach ( $level3_list as $v ) {
			$new_level2_list [$v ['type']] ['s'] [] = array (
					'v' => $v ['tid'],
					'n' => $v ['name'],
					'level' => $v ['level'],
					'up_level' => $v ['type'] 
			);
		}
		foreach ( $new_level2_list as $k => $v ) {
			$new_level1_list [$v ['up_level']] ['s'] [] = $v;
		}
		return array_values ( $new_level1_list );
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
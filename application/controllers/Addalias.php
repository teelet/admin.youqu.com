<?php

/**
 * 添加别名
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:14
 */
class AddaliasController extends AbstractController {
	
	/**
	 * 默认动作
	 */
	public function indexAction() {
		$tag_list = Tag_TagModel::addAliasIndex ();
		$this->tpl = 'addAlias.phtml';
		$this->data ['tag_list'] = json_encode ( $tag_list );
		$this->assign ();
		return $this->end ();
	}
	/**
	 * 查询别名
	 */
	public function searchAction() {
		// 获取查询参数
		$tag_level1 = trim ( Comm_Context::param ( "tag_level1", 0 ) );
		$tag_level2 = trim ( Comm_Context::param ( "tag_level2", 0 ) );
		$tag_level3 = trim ( Comm_Context::param ( "tag_level3", 0 ) );
		$tag_id = 0;
		if ($tag_level1 != 0)
			$tag_id = $tag_level1;
		if ($tag_level2 != 0)
			$tag_id = $tag_level2;
		if ($tag_level3 != 0)
			$tag_id = $tag_level3;
			// 查询别名列表
		$alias_list = Tag_AliasModel::getAliasListByTid ( $tag_id );
		$tag_list = Tag_TagModel::addAliasIndex ();
		$this->tpl = 'addAlias.phtml';
		$this->data ['tag_list'] = json_encode ( $tag_list );
		$this->data ['alias_list'] = $alias_list;
		$this->data ['tag_id'] = $tag_id;
		$this->assign ();
		return $this->end ();
	}
	/**
	 * 添加别名
	 */
	public function addAction() {
		// 获取标签id
		$tag_id = trim ( Comm_Context::form ( "tag_id", 0 ) );
		$tag_id_level1 = trim ( Comm_Context::form ( "tag_id_level1", 0 ) );
		$tag_id_level2 = trim ( Comm_Context::form ( "tag_id_level2", 0 ) );
		$tag_id_level3 = trim ( Comm_Context::form ( "tag_id_level3", 0 ) );
		$alias_name = trim ( Comm_Context::form ( "alias_name", "" ) );
		if ($tag_id_level1 != 0)
			$tag_id = $tag_id_level1;
		if ($tag_id_level2 != 0)
			$tag_id = $tag_id_level2;
		if ($tag_id_level3 != 0)
			$tag_id = $tag_id_level3;
		if ($tag_id == 0) {
			echo '请选择标签!';
			die ();
		}
		if (empty ( $alias_name )) {
			echo '请输入标签别名!';
			die ();
		}
		// 根据标签id查询标签详情
		$tag = Tag_TagModel::getTagByTid ( $tag_id );
		if (! $tag) {
			echo '标签不存在!';
			die ();
		}
		$res = Tag_AliasModel::insertAlias ( $tag, $alias_name );
		if (! $res) {
			echo '添加别名失败!';
			die ();
		}
		$tag_list = Tag_TagModel::addAliasIndex ();
		$this->tpl = 'addAlias.phtml';
		$this->data ['tag_list'] = json_encode ( $tag_list );
		$this->data ['tag_id'] = $tag_id;
		$this->assign ();
		return $this->end ();
	}
}
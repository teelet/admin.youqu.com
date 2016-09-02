<?php

/**
 * 添加别名
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:14
 */
class AddaliasController extends AbstractController {
	
	/**
	 * 添加别名页面
	 */
	public function indexAction() {
		$this->commonAction ();
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
		$this->data ['alias_list'] = $alias_list;
		$this->data ['tag_id'] = $tag_id;
		$this->commonAction ( "查询成功!" );
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
			$this->commonAction ( "请选择标签!" );
			return $this->end ();
		}
		if (empty ( $alias_name )) {
			$this->commonAction ( "请输入标签别名!" );
			return $this->end ();
		}
		// 根据标签id查询标签详情
		$tag = Tag_TagModel::getTagByTid ( $tag_id );
		if (! $tag) {
			$this->commonAction ( "标签不存在!" );
			return $this->end ();
		}
		$res = Tag_AliasModel::insertAlias ( $tag, $alias_name );
		if (! $res) {
			$this->commonAction ( "添加别名失败!" );
			return $this->end ();
		}
		$this->commonAction ( "添加别名成功!" );
		return $this->end ();
	}
	/**
	 * 共同方法
	 */
	public function commonAction($res_msg = "") {
		$tag_list = Tag_TagModel::getTagListByLevel ( 1 );
		$this->tpl = 'addAlias.phtml';
		$this->data ['tag_list'] = $tag_list;
		$this->data ['res_msg'] = $res_msg;
		$this->assign ();
	}
}
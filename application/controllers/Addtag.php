<?php
/**
 * 添加标签
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:12
 */
class AddtagController extends AbstractController {
	
	/**
	 * 默认动作
	 */
	public function indexAction() {
		// 获取级联下拉列表
		$level_list = Tag_TagModel::trans2level4AddTag ();
		$this->tpl = 'addTag.phtml'; // 试图页面
		$this->data ['level_list'] = json_encode ( $level_list );
		$this->assign ();
		return $this->end ();
	}
	/**
	 * 添加标签
	 */
	public function addAction() {
		$tag_name = trim ( Comm_Context::form ( "tag_name", "" ) );
		$tag_level = trim ( Comm_Context::form ( "tag_level", "" ) );
		$tag_id_level1 = trim ( Comm_Context::form ( "tag_id_level1", "" ) );
		$tag_id_level2 = trim ( Comm_Context::form ( "tag_id_level2", "" ) );
		if (empty ( $tag_name )) {
			echo "请输入标签名称!";
			die ();
		}
		$parent_tag_id = 0;
		if ($tag_id_level2 != 0) {
			// 选取的是level3
			$parent_tag_id = $tag_id_level2;
		} elseif ($tag_id_level1 != 0) {
			// 选取的是level2
			$parent_tag_id = $tag_id_level1;
		} else {
			// 选取的是level1
			$parent_tag_id = 0;
		}
		$ret = Tag_TagModel::insertTag ( $parent_tag_id, $tag_name, $tag_level );
		if (! $ret) {
			echo "添加失败!";
			die ();
		}
		// 获取级联下拉列表
		$level_list = Tag_TagModel::trans2level4AddTag ();
		$this->tpl = 'addTag.phtml'; // 试图页面
		$this->data ['level_list'] = json_encode ( $level_list );
		$this->assign ();
		return $this->end ();
	}
}

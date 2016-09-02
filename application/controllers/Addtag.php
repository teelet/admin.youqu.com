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
		$this->commonAction ();
		return $this->end ();
	}
	/**
	 * 添加标签
	 */
	public function addAction() {
		$tag_name = trim ( Comm_Context::form ( "tag_name", "" ) );
		$level = trim ( Comm_Context::form ( "tag_level", "" ) );
		$gid = trim ( Comm_Context::form ( "tag_id_level1", "" ) );
		$type = trim ( Comm_Context::form ( "tag_id_level2", "" ) );
		$res_msg = "";
		if (empty ( $tag_name )) {
			$res_msg = "请输入标签名称!";
			$this->commonAction ( $res_msg );
			return $this->end ();
		}
		if ($gid == 0 && $level > 1) {
			$res_msg = "请选择游戏!";
			$this->commonAction ( $res_msg );
			return $this->end ();
		}
		if ($type == 0 && $level > 2) {
			$res_msg = "请选择二级标签!";
			$this->commonAction ( $res_msg );
			return $this->end ();
		}
		$ret = Tag_TagModel::insertTag ( $tag_name, $level, $gid, $type );
		if (! $ret) {
			$res_msg = "添加失败!";
			$this->commonAction ( $res_msg );
			return $this->end ();
		}
		$res_msg = "添加成功!";
		$this->commonAction ( $res_msg );
		return $this->end ();
	}
	/**
	 * 统一处理
	 */
	public function commonAction($res_msg) {
		$level_list = Tag_TagModel::getLevelList ();
		$this->tpl = 'addTag.phtml'; // 视图页面
		$this->data ['level_list'] = $level_list;
		$this->data ['res_msg'] = $res_msg;
		$this->assign ();
	}
}

<?php
/**
 * ajax获取标签列表
 * User: zhangyang
 * Date: 16/9/2
 * Time: 下午2:15
 */
class Ajax_TaglistController extends AbstractController {
	/**
	 * 获取一级标签的下拉列表
	 */
	public function firstlevelAction() {
		// 获取一级列表
		$first_level = Tag_TagModel::getTagListByLevel ( 1 );
		// 将列表封装成select的option格式
		$ret = Tag_TagModel::getTagSelectOptions ( $first_level );
		echo $ret;
		exit ();
	}
	/**
	 * 获取二级标签的下拉列表
	 */
	public function secondlevelAction() {
		// 获取一级标签id
		$gid = trim ( Comm_Context::param ( "gid", 0 ) );
		// 根据一级标签id获取二级标签列表
		$second_level = Tag_TagModel::getTagListByGid ( 2, $gid );
		// 将列表封装成select的option格式
		$ret = Tag_TagModel::getTagSelectOptions ( $second_level );
		echo $ret;
		exit ();
	}
	/**
	 * 获取三级标签的下拉列表
	 */
	public function thirdlevelAction() {
		// 获取二级标签id
		$type = trim ( Comm_Context::param ( "type", 0 ) );
		// 根据二级标签id获取三级标签列表
		$third_level = Tag_TagModel::getTagListByType ( 3, $type );
		// 将列表封装成select的option格式
		$ret = Tag_TagModel::getTagSelectOptions ( $third_level );
		echo $ret;
		exit ();
	}
	/**
	 * 默认动作
	 */
	public function indexAction() {
		$username = trim ( Comm_Context::form ( 'username', '' ) );
		$password = trim ( Comm_Context::form ( 'password', '' ) );
		if (empty ( $username ) || empty ( $password )) {
			$this->data = array (
					'status' => 1,
					'errorMsg' => '用户名、密码 错误!' 
			);
			return $this->end ();
		} else {
			// 验证用户名+密码
			$msg = User_UserModel::checkLoginInfo ( $username, $password );
			switch ($msg) {
				case - 1 :
					$this->data = array (
							'status' => 1,
							'type' => 1,
							'errorMsg' => '用户名不存在!' 
					);
					break;
				case - 2 :
					$this->data = array (
							'status' => 1,
							'type' => 2,
							'errorMsg' => '密码错误!' 
					);
					break;
				case 0 :
					$this->data = array (
							'status' => 0,
							'errorMsg' => '成功!' 
					);
					break;
			}
			// 入session,cookie
			setcookie ( 'user', $username );
			setcookie ( 'status', 'login' );
		}
		
		$this->jsonResult ();
		return $this->end ();
	}
}
<?php
/**
 *
 * 设置 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Setup.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\controller;

use think\Url;
use think\Lang;
use app\member\controller\Base;
use app\member\Logic\Setup as MemberSetup;

class Setup extends Base
{

    /**
     * 会员基本信息
     * @access public
     * @param
     * @return string
     */
    public function bases()
    {
        // AJAX获得地区
        if ($this->request->isAjax()) {
            return $this->getRegion();
        }

        if ($this->request->isPost()) {
            $result = $this->validate($_POST, 'Member.editor');
            if (true !== $result) {
                $this->error(Lang::get($result));
            }
            $member = new MemberSetup();
            $result = $member->editor();
            if (true === $result) {
                $this->success(Lang::get('success editor'));
            } else {
                $this->error(Lang::get('error editor'));
            }
        }

        $member = new MemberSetup();

        $data = $member->getUserInfo();

        $this->assign('region', $member->getRegion(1));
        $this->assign('city', $member->getRegion($data['province']));
        $this->assign('area', $member->getRegion($data['city']));
        $this->assign('user_data', $data);

        return $this->fetch();
    }

    /**
     * 密码
     * @access public
     * @param
     * @return string
     */
    public function password()
    {
        $member = new MemberSetup();

        if ($this->request->isPost()) {
            $result = $this->validate($_POST, 'Member.editor_pwd');
            if (true !== $result) {
                $this->error(Lang::get($result));
            }
            $result = $member->updatePassword();
            if (true === $result) {
                $this->success(Lang::get('success editor'));
            } else {
                $this->error(Lang::get('error editor'));
            }
        }

        $this->assign('user_data', $member->getUserInfo());
        return $this->fetch();
    }

    /**
     * 头像
     * @access public
     * @param
     * @retun string
     */
    public function portrait()
    {
        $member = new MemberSetup();
        $this->assign('user_data', $member->getUserInfo());
        return $this->fetch();
    }

    /**
     * AJAX获得地区
     * @access private
     * @param
     * @return string html option
     */
    private function getRegion($parent_id=1)
    {
        $id = $this->request->post('id/f');

        $member = new MemberSetup();
        $data = $member->getRegion($id);

        $option = '';
        foreach ($data as $key => $value) {
            $option .= '<option class="op" value="' . $value['id'] . '">';
            $option .= $value['name'];
            $option .= '</option>';
        }
        return $option;
    }
}

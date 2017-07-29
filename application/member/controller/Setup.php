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
use app\member\Logic\Setup as LogicSetup;

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
            $logic = new LogicSetup();
            $result = $logic->editor();
            if (true === $result) {
                $this->success(Lang::get('success editor'));
            } else {
                $this->error(Lang::get('error editor'));
            }
        }

        $logic = new LogicSetup();

        $data = $logic->getUserInfo();

        $this->assign('region', $logic->getRegion(1));
        $this->assign('city', $logic->getRegion($data['province']));
        $this->assign('area', $logic->getRegion($data['city']));
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
        $logic = new LogicSetup();

        if ($this->request->isPost()) {
            $result = $this->validate($_POST, 'Member.editor_pwd');
            if (true !== $result) {
                $this->error(Lang::get($result));
            }
            $result = $logic->updatePassword();
            if (true === $result) {
                $this->success(Lang::get('success editor'));
            } else {
                $this->error(Lang::get('error editor'));
            }
        }

        $this->assign('user_data', $logic->getUserInfo());
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
        $logic = new LogicSetup();
        $this->assign('user_data', $logic->getUserInfo());
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

        $logic = new LogicSetup();
        $data = $logic->getRegion($id);

        $option = '';
        foreach ($data as $key => $value) {
            $option .= '<option class="op" value="' . $value['id'] . '">';
            $option .= $value['name'];
            $option .= '</option>';
        }
        return $option;
    }
}

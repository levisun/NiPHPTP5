<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\controller;

use think\Url;
use think\Lang;
use app\member\controller\Base;
use app\member\logic\Account as LogicAccount;
use app\member\logic\OAuth as LogicOAuth;

class Index extends Base
{

    public function index()
    {

    }

    /**
     * 登录
     * @access public
     * @param
     * @return string
     */
    public function login()
    {
        // 第三方登录
        if ($this->request->has('type') && $this->request->has('code')) {
            $this->oauth();
        }

        if ($this->request->isPost()) {
            $result = $this->validate($_POST, 'Account.login');

            if(true === $result){
                $logic = new LogicAccount;
                $result = $logic->checkLogin();
            }

            if (true === $result) {
                $this->redirect(Url::build('/my'));
            } else {
                $this->error(Lang::get($result));
            }
        }
        return $this->fetch();
    }

    /**
     * 第三方登录
     * @access public
     * @param
     * @return ???
     */
    public function oauth()
    {
        $logic = new LogicOAuth;
        $this->redirect($logic->login());
    }

    /**
     * 注销
     * @access public
     * @param
     * @return void
     */
    public function logout()
    {
        $logic = new LogicAccount;
        $result = $logic->logout();
        if (true === $result) {
            $this->redirect(Url::build('/login'));
        }
    }

    /**
     * 注册
     * @access public
     * @param
     * @return string
     */
    public function reg()
    {
        return $this->fetch();
    }

    /**
     * 找回密码
     * @access public
     * @param
     * @return string
     */
    public function forget()
    {
        return $this->fetch();
    }
}

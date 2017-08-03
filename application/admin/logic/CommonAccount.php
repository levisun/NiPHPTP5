<?php
/**
 *
 * 帐户权限与权限导航菜单等常用设置 - 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: CommonAccount.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/28
 */
namespace app\admin\logic;

use think\Model;
use think\Config;
use think\Lang;
use think\Request;
use think\Session;
use think\Url;
use net\IpLocation;
use util\Rbac;
use app\admin\model\Category as ModelCategory;
use app\admin\model\Action as ModelAction;
use app\admin\model\ActionLog as ModelActionLog;
use app\admin\model\RequestLog as ModelRequestLog;

class CommonAccount extends Model
{
    protected $request = null;
    protected $_action = [
        'login',
        'logout',
        'upload',
        'delupload',
    ];

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 执行日志
     * @access public
     * @param  string $action_name 行为名称
     * @param  intval $record_id   数据ID
     * @param  string $remark      备注
     * @return void
     */
    public function actionLog($action_name, $record_id, $remark)
    {
        $map = ['name' => $action_name];

        $action = new ModelAction;
        $id =
        $action->where($map)
        ->value('id');

        if (empty($id)) {
            return false;
        }

        $ip = new IpLocation();
        $area = $ip->getlocation($this->request->ip(0, true));

        $user_id = Session::get(Config::get('USER_AUTH_KEY'));
        $user_id = $user_id ? $user_id : 0;
        $data = [
            'action_id' => $id,
            'user_id'   => $user_id,
            'action_ip' => $area['ip'] . '[' . $area['country'] . $area['area'] . ']',
            'model'     => $this->request->controller() . '-' . $this->request->action(),
            'record_id' => $record_id,
            'remark'    => $remark
        ];

        $action_log = new ModelActionLog;
        $action_log->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        // 删除过期的日志(保留三个月)
        $map = ['create_time' => ['ELT', strtotime('-90 days')]];
        $action_log->where($map)
        ->delete();
    }

    /**
     * 记录请求日志
     * @access public
     * @param
     * @return void
     */
    public function requestLog($login = false)
    {
        $ip = new IpLocation();
        $request_log = new ModelRequestLog;

        // 删除过期的日志(保留三个月)
        $map = ['create_time' => ['ELT', strtotime('-90 days')]];
        $request_log->where($map)
        ->delete();

        // 日志是否存在
        $map = [
            'ip'   => $this->request->ip(0, true),
            'type' => 1
        ];

        $result =
        $request_log->where($map)
        ->find();

        $get_params = array_merge($this->request->get(), $this->request->param());
        if (!empty($get_params['password'])) {
            unset($get_params['password']);
        }
        $post_params = $this->request->post();
        if (!empty($post_params['password'])) {
            unset($post_params['password']);
        }

        if ($result) {
            // 更新同IP日志
            $data = [
                'get_params'  => serialize($get_params),
                'post_params' => serialize($post_params),
                'url'         => $this->request->url(true),
            ];
            $data['count'] = $login ? ['exp', 'count+1'] : 0;

            $request_log->allowField(true)
            ->isUpdate(true)
            ->save($data, $map);
        } else {
            $area = $ip->getlocation($this->request->ip(0, true));
            $data = [
                'ip'          => $this->request->ip(0, true),
                'ip_attr'     => $area['country'] . $area['area'],
                'get_params'  => serialize($get_params),
                'post_params' => serialize($post_params),
                'url'         => $this->request->url(true),
                'count'       => 1,
                'type'        => 1
            ];
            $request_log->data($data)
            ->allowField(true)
            ->isUpdate(false)
            ->save();
        }
    }

    /**
     * IP请求错误
     * 大于三次请求并在3小时内
     * @access public
     * @param
     * @return void
     */
    public function ipRequestError()
    {
        $ip = new IpLocation();
        $request_log = new ModelRequestLog;

        $map = [
            'ip'          => $this->request->ip(0, true),
            'count'       => ['EGT', 4],
            'type'        => 1,
            'update_time' => ['EGT', strtotime('-3 hours')]
        ];

        $result =
        $request_log->where($map)
        ->find();

        return $result ? true : false;
    }

    /**
     * 系统信息
     * @access public
     * @param
     * @return array
     */
    public function getSysData()
    {
        $auth_data = [];
        if (in_array($this->request->action(), $this->_action)) {
            $auth_data = ['title' => $this->getWebSiteTitle()];
        } else {
            $_menu = Lang::get('_menu');
            $auth_data = [
                'auth_menu'  => $this->getAuthMenu(),
                'title'      => $this->getWebSiteTitle(),
                'breadcrumb' => $this->getBreadcrumb(),
                'sub_title'  => $_menu[
                strtolower($this->request->controller() . '_' . $this->request->action())
                ]
            ];
        }
        return $auth_data;
    }

    /**
     * 面包屑
     * @access protected
     * @param
     * @return array
     */
    protected function getBreadcrumb()
    {
        $bn = [
            'Settings' => 'info',
            'Theme'    => 'template',
            'Category' => 'category',
            'Content'  => 'content',
            'User'     => 'member',
            'Wechat'   => 'keyword',
            'Mall'     => 'goods',
            'Expand'   => 'log',
        ];

        $_nav = Lang::get('_nav');
        $_menu = Lang::get('_menu');
        $breadcrumb = '<li><a href="' . Url::build('settings/info') . '">';
        $breadcrumb .= Lang::get('website home') . '</a></li>';

        $breadcrumb .= '<li><a href="';
        $breadcrumb .= Url::build($this->request->controller() . '/' . $bn[$this->request->controller()]);
        $breadcrumb .= '">' . $_nav[strtolower($this->request->controller())] . '</a></li>';

        $breadcrumb .= '<li><a href="';
        $breadcrumb .= Url::build($this->request->controller() . '/' . $this->request->action()) . '">';
        $breadcrumb .= $_menu[strtolower($this->request->controller() . '_' . $this->request->action())];
        $breadcrumb .= '</a></li>';

        if ($this->request->param('cid')) {
            $bread = $this->getBreadcrumbParent($this->request->param('cid'));
        }
        if ($this->request->param('pid')) {
            $bread = $this->getBreadcrumbParent($this->request->param('pid'));
        }

        if (!empty($bread)) {
            $count = count($bread);
            foreach ($bread as $key => $value) {
                if ($key+1 == $count) {
                    $breadcrumb .= '<li class="active"><a>' . $value['name'] . '</a></li>';
                } else {
                    $breadcrumb .= '<li><a href="' . Url::build('content/content', ['pid' => $value['id']]) . '">' . $value['name'] . '</a></li>';
                }
            }
        }

        return $breadcrumb;
    }

    /**
     * 获得面包屑父级栏目
     * @access protected
     * @param  intval $parent_id 父ID
     * @return intval
     */
    protected function getBreadcrumbParent($parent_id)
    {
        $field = [
            'id',
            'pid',
            'name'
        ];
        $map = [
            'id'   => $parent_id,
            'lang' => Lang::detect()
        ];

        $category = new ModelCategory;
        $result =
        $category->field($field)
        ->where($map)
        ->find();

        $cate_data = !empty($result) ? $result->toArray() : null;

        if (!empty($cate_data['pid'])) {
            $breadcrumb = $this->getBreadcrumbParent($cate_data['pid']);
        }

        $breadcrumb[] = $cate_data;
        return $breadcrumb;
    }

    /**
     * 网站标题
     * @access protected
     * @param
     * @return array
     */
    protected function getWebSiteTitle()
    {
        if (in_array($this->request->action(), $this->_action)) {
            if ('upload' == $this->request->action()) {
                return Lang::get('upload file') . ' - NIPHPCMS';
            }
            return  Lang::get('manage login') . ' - NIPHPCMS';
        }

        $_nav = Lang::get('_nav');
        $_menu = Lang::get('_menu');
        $title = $_menu[strtolower($this->request->controller() . '_' . $this->request->action())];
        $title .= ' - ' . $_nav[strtolower($this->request->controller())] . ' - NIPHPCMS';
        return $title;
    }

    /**
     * 权限菜单
     * @access protected
     * @param
     * @return array
     */
    protected function getAuthMenu()
    {
        if (!Session::get('_ACCESS_LIST')) {
            return false;
        }
        $auth = Session::get('_ACCESS_LIST');
        $auth = $auth[strtoupper($this->request->module())];
        $_nav = Lang::get('_nav');
        $_menu = Lang::get('_menu');
        $auth_menu = array();
        foreach ($auth as $key => $value) {
            $controller = strtolower($key);
            foreach ($value as $k => $val) {
                $action = strtolower($k);
                $auth_menu[$controller]['name'] = $_nav[$controller];
                $auth_menu[$controller]['menu'][] = [
                    'action' => $action,
                    'url'    => Url::build($controller . '/' . $action),
                    'lang'   => $_menu[$controller . '_' . $action],
                ];
            }
        }
        return $auth_menu;
    }

    /**
     * 权限验证
     * @access public
     * @param
     * @return mixed
     */
    public function accountAuth()
    {
        $action = explode(',', Config::get('NOT_AUTH_ACTION'));
        $user_auth_key = Session::get(Config::get('USER_AUTH_KEY'));

        if (!in_array($this->request->action(), $action) && !$user_auth_key) {
            return Url::build('account/login');
        }
        if (in_array($this->request->action(), $action) && $user_auth_key) {
            return Url::build('settings/info');
        }

        Rbac::checkLogin();
        Rbac::saveAccessList();
        if (Rbac::AccessDecision()) {
            Session::set('_ACCESS_LIST', Rbac::getAccessList($user_auth_key));
            return true;
        }
    }
}

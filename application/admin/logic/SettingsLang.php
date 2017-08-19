<?php
/**
 *
 * 语言设置 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: SettingsLang.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Config;
use util\File as UtilFile;

class SettingsLang extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 获得语言设置数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $data['lang_switch_on']   = Config::get('lang_switch_on');
        $data['lang_list']        = Config::get('lang_list');
        $data['sys_default_lang'] = Config::get('default_lang');
        $data['web_default_lang'] = include_once(CONF_PATH . 'website.php');
        $data['web_default_lang'] = $data['web_default_lang']['default_lang'];
        return $data;
    }

    /**
     * 修改语言设置
     * @access public
     * @param
     * @return mixed
     */
    public function editor()
    {
        $str = ['array ('=> '[', ')' => ']'];

        $config = include(CONF_PATH . 'admin/config.php');
        $config['default_lang'] = $this->request->post('system');

        $lang_switch_on = $this->request->post('lang_switch_on');
        $config['lang_switch_on'] = $lang_switch_on ? true : false;
        $config = var_export($config, true);
        $config = '<?php return ' . strtr($config, $str) . ';';
        UtilFile::create(CONF_PATH . 'admin/config.php', $config, true);



        $config = include(CONF_PATH . 'website.php');
        $config['default_lang'] = $this->request->post('website');

        $lang_switch_on = $this->request->post('lang_switch_on');
        $config['lang_switch_on'] = $lang_switch_on ? true : false;
        $config = var_export($config, true);
        $config = '<?php return ' . strtr($config, $str) . ';';
        UtilFile::create(CONF_PATH . 'website.php', $config, true);

        return true;
    }
}

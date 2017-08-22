<?php
/**
 *
 * 列表 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Entry.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;

use think\Loader;
use think\Url;
use think\Lang;
use app\index\controller\Base;
use app\index\logic\Article as LogicArticle;

class Entry extends Base
{
    protected $beforeActionList = [
        'first',
    ];

    /**
     * 列表页
     * @access public
     * @param
     * @return string
     */
    public function index()
    {
        $model = ['article', 'download', 'picture', 'product'];
        if (in_array($this->tableName, $model)) {
            $logic = new LogicArticle;
            $logic->setTableModel($this->tableName);
        } else {
            // page link feedback message
            $logic = Loader::model($this->tableName, 'logic');
        }

        // feedback or message
        if ($this->request->isPost() && in_array($this->tableName, ['feedback', 'message'])) {
            $result = $this->validate($_POST, ucfirst($this->tableName));
            if (true !== $result) {
                $this->error($result);
                // $this->error(Lang::get($result));
            }

            $result = $logic->added();
            if (true === $result) {
                $url = Url::build('/list/' . $this->request->param('cid'));
                $this->success(Lang::get('success ' . $this->tableName . ' added'), $url);
            } else {
                $this->error(Lang::get('error ' . $this->tableName . ' added'));
            }
        }

        $data = $logic->getListData();

        $this->assign('data', $data['list']);
        $this->assign('list', $data['list']);
        $this->assign('page', $data['page']);
        $this->assign('count', count($data['list']));

        return $this->fetch('entry/' . $this->tableName);
    }
}

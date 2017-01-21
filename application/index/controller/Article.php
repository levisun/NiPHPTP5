<?php
/**
 *
 * 内容 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Article.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;
use think\Url;
use think\Lang;
use app\index\controller\Base;
use app\index\logic\Article as IndexArticle;
class Article extends Base
{

    /**
     * 内容页
     * @access public
     * @param
     * @return string
     */
    public function index()
    {
        $model = new IndexArticle;
        $model->setTableModel($this->table_name);

        $data = $model->getArticle();

        if ($data['is_link']) {
            $this->redirect(Url::build('/jump/' . $data['category_id'] . '/' . $data['id']), 302);
        }

        $this->assign('data', $data);

        $web_info = $this->getCatWebInfo();
        $replace = [
            '__TITLE__'       => $data['title'] . ' - ' . $web_info['title'],
            '__KEYWORDS__'    => $data['keywords'] ? $data['keywords'] : $web_info['keywords'],
            '__DESCRIPTION__' => $data['description'] ?
                                    $data['description'] :
                                    $web_info['description'],
        ];
        $this->view->replace($replace);

        return $this->fetch('article/' . $this->table_name);
    }
}
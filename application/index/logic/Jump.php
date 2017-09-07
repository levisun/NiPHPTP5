<?php
/**
 *
 * 跳转 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Jump.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/12/06
 */
namespace app\index\logic;

use think\Request;
use think\Lang;
use think\Url;
use think\Loader;
use think\Cache;

class Jump
{
    protected $request = null;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * 获得跳转链接
     * @access public
     * @param
     * @return string
     */
    public function jump($name)
    {
        $cid = $this->request->param('cid/f');
        $id  = $this->request->param('id/f');
        $map = [
            'category_id' => $cid,
            'id'          => $id,
            'lang'        => Lang::detect(),
        ];

        $model = Loader::model(ucfirst($name), 'model', false, 'admin');

        // 更新点击数
        $model->where($map)
        ->setInc('hits');

        // 查询跳转链接
        $result =
        $model->field(true)
        ->where($map)
        ->cache(!APP_DEBUG)
        ->find();

        $data = $result ? $result->toArray() : [];

        if (isset($data['is_link']) && !$data['is_link']) {
            if (in_array($name, ['article', 'download', 'picture', 'product'])) {
                $data['url'] = Url::build('/article/' . $data['category_id'] . '/' . $data['id']);
            } else {
                $data['url'] = Url::build('/list/' . $data['category_id']);
            }
        }

        return $data['url'];
    }
}

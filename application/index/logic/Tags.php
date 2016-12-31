<?php
/**
 *
 * 标签 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  index\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Tags.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\logic;
use think\Model;
use think\Request;
use think\Lang;
use think\Url;
use app\admin\model\Tags as IndexTags;
use app\admin\model\Article as IndexArticle;
use app\admin\model\Download as IndexDownload;
use app\admin\model\Picture as IndexPicture;
use app\admin\model\Product as IndexProduct;
class Tags extends Model
{
	protected $request    = null;

	protected function initialize()
	{
		parent::initialize();

		$this->request = Request::instance();
	}

	/**
	 * 列表数据
	 * @access public
	 * @param
	 * @return array
	 */
	public function getListData()
	{
		$map = [
			't.lang' => Lang::detect(),
		];

		$tags = new IndexTags;
		$result =
		$tags->view('tags t', ['name'=>'tags_name'])
		->view('tags_article ta', true, 'ta.tags_id=t.id')
		->where($map)
		->select();

		$article_id = $category_id = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			$article_id[] = $value['article_id'];
			$category_id[] = $value['category_id'];
		}
		$article_id  = array_unique($article_id);
		$category_id = array_unique($category_id);


		$field = [
			'id',
			'title',
			'keywords',
			'description',
			'thumb',
			'category_id',
			'type_id',
			'is_com',
			'is_top',
			'is_hot',
			'hits',
			'comment_count',
			'username',
			'url',
			'is_link',
			'create_time',
			'update_time',
		];
		$map = [
			'id' => [
				'in', implode(',', $article_id)
			],
			'category_id' => [
				'in', implode(',', $category_id)
			],
			'is_pass'   => 1,
			'lang'      => Lang::detect(),
			'show_time' => ['ELT', strtotime(date('Y-m-d'))]
		];

		$download = new IndexDownload;
		$union[] = $download->name('download')->field($field)->where($map)->fetchSql()->select();
		$picture = new IndexPicture;
		$union[] = $picture->name('picture')->field($field)->where($map)->fetchSql()->select();
		$product = new IndexProduct;
		$union[] = $product->name('product')->field($field)->where($map)->fetchSql()->select();

		// $download = new IndexDownload;
		// $count[] = $download->name('download')->field($field)->where($map)->fetchSql()->count();
		// $picture = new IndexPicture;
		// $count[] = $picture->name('picture')->field($field)->where($map)->fetchSql()->count();
		// $product = new IndexProduct;
		// $count[] = $product->name('product')->field($field)->where($map)->fetchSql()->count();


		trace($union);

		$article = new IndexArticle;
		$result =
		$article->field($field)
		->where($map)
		->union($union)
		->paginate();halt(1);

		/*$list = [];
		foreach ($result as $value) {
			$value = $value->toArray();
			if ($value['is_link']) {
				$value['url'] = Url::build('/jump/' . $value['category_id'] . '/' . $value['id']);
			} else {
				$value['url'] = Url::build('/article/' . $value['category_id'] . '/' . $value['id']);
			}
			$value['cat_url'] = Url::build('/entry/' . $value['category_id']);
			$list[] = $value;
		}

		$page = $result->render();*/

		trace($tags->getLastSql());
		// trace($tags_list);
	}
}
<?php
namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Terms;
use ZPhal\Models\TermTaxonomy;

/**
 * 文章类
 * Class PostController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PostController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {

    }

    public function newAction()
    {

    }

    public function addTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        $name = $this->request->getPost('name', ['string','trim']);
        $slug = $this->request->getPost('slug', ['string','trim']);
        $parent = $this->request->getPost('parent', 'int');
        $description = $this->request->getPost('description', ['string','trim']);

        $terms = new Terms();
        $terms->name = $name;
        $terms->slug = $slug;

        $termTaxonomy = new TermTaxonomy();
        $termTaxonomy->terms  = $terms;
        $termTaxonomy->taxonomy = $type;
        $termTaxonomy->description = $description;
        $termTaxonomy->parent   = $parent;

        if ($termTaxonomy->save()){
            $this->flash->success("创建成功");
            return $this->response->redirect("admin/post/taxonomy/".$type);
        }else{
            $messages = $this->getErrorMsg($termTaxonomy, "创建失败");
            $this->flash->error($messages);
            return $this->response->redirect("admin/post/taxonomy/".$type);
        }
    }

    public function taxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");

        if ($type == 'category'){
            $topTitle = '分类';
            $topSubtitle = '文章的分类';

            /**
             * 获取分类目录
             */
            $category = $this->modelsManager->executeQuery(
                "SELECT tt.term_taxonomy_id, tt.term_id, tt.description, tt.parent, tt.count, t.name, t.slug
                  FROM ZPhal\Models\TermTaxonomy AS tt
                  LEFT JOIN ZPhal\Models\Terms AS t ON t.term_id=tt.term_id
                  WHERE tt.taxonomy = :taxonomy:
                  ORDER BY t.term_id DESC",
                [
                    "taxonomy" => "category",
                ]
            )->toArray();

            $categoryTree = $this->makeTree($category, $pk='term_id', $pid='parent', $child='sun', $root=0);

            /**
             * 获取分类列表
             */

            $this->view->setVars(
                [
                    "type" => $type,
                    "topTitle" => $topTitle,
                    "topSubtitle" => $topSubtitle,
                    "categoryTree" => $this->treeHtml($categoryTree)
                ]
            );

        } elseif ($type == 'tag'){

            $topTitle = '标签';
            $topSubtitle = '文章贴标签';

            $this->view->setVars(
                [
                    "type" => $type,
                    "topTitle" => $topTitle,
                    "topSubtitle" => $topSubtitle
                ]
            );

        } else{

            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

    /**
     * 返回分类树结构
     * @param array $list 要排列的数组
     * @param string $pk 唯一标志,id
     * @param string $pid 父id
     * @param string $child 子集合key
     * @param int $root 层级
     * @return array
     */
    function makeTree($list, $pk='', $pid='parent', $child='sun', $root=0)
    {
        $tree = [];
        foreach($list as $key=> $val){
            if($val[$pid]==$root){
                unset($list[$key]);
                if(! empty($list)){
                    $child=$this->makeTree($list, $pk, $pid, $child, $val[$pk]);
                    if(!empty($child)){
                        $val['sun']=$child;
                    }
                }
                $tree[]=$val;
            }
        }
        return $tree;
    }

    /**
     * 返回分类要输出的html结构
     * @param $categoryTree
     * @param string $html
     * @param int $deep
     * @return string
     */
    function treeHtml($categoryTree, $html='', $deep=0)
    {
        if ($html == ''){
            $html = '<option value="0">无</option>';
        }

        $nbsp = '&nbsp;&nbsp;';
        $tags = '';
        if ($deep){
            for ($i=0; $i<=$deep;$i++){
                $tags .= $nbsp;
            }
        }

        foreach ($categoryTree as $category){
            $html .= '<option value="'.$category['term_id'].'">'.$tags.$category['name'].'</option>';
            if (!empty($category['sun'])){
                $this->treeHtml($category['sun'], $html, $deep+1);
            }
        }
        return $html;
    }
}
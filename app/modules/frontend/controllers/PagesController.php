<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Posts;

class PagesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("page");

        /**
         * widget for the template
         */
        $this->view->setVars([
            'widgetCategory' => $this->widget->getCategoryList(),
            'widgetNewArticle' => $this->widget->getNewArticles([
                'ulClass' => 'fa-ul ml-4 mb-0',
                'before' => '<i class="fa-li fa fa-angle-double-right"></i>'
            ])
        ]);
    }

    public function indexAction($param='')
    {
        if ($param!= '' && !$this->view->getCache()->exists('pages-'.$param)) {
            $post = Posts::findFirst([
                "conditions" => "post_name = ?1 AND post_status = 'publish' AND post_type = 'page'",
                "bind"       => [
                    1 => $param,
                ]
            ]);

            if ($post){
                $this->visitCounter->calculate($post); // 访问量计算

                $this->tag->prependTitle($post->post_title . " - ");

                /**
                 * Get postmeta
                 */
                $postMeta =  $post->PostMeta->toArray();

                $newPostMeta = [];
                foreach ($postMeta as $meta){
                    $newPostMeta[$meta['meta_key']] = $meta['meta_value'];
                }

                /**
                 * make description
                 */
                if (isset($newPostMeta['description']) && !empty($newPostMeta['description'])){
                    $coverDescription = $newPostMeta['description'];
                }else{
                    $coverDescription = null;
                }

                $post = $post->toArray();
                $post['post_date'] = date('Y-m-d H:i', strtotime($post['post_date']));

                $this->view->setVars([
                    'post' => $post,
                    'postMeta' => $newPostMeta,
                    'coverDescription' => $coverDescription,
                ]);

                /**
                 * TODO 判断$newPostMeta['_zp_page_template']赋值到不同的模板
                 */

            }else{
                $this->dispatcher->forward(
                    [
                        "controller" => "error",
                        "action"    => "route404"
                    ]
                );
            }
        }

        $this->view->cache(
            [
                'key' => 'pages-'.$param,
            ]
        );
    }

}

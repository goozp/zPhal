<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Posts;

class ArticlesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("article");
    }

    /**
     * 文章页
     *
     * @param $id
     */
    public function indexAction($id)
    {
        $post = Posts::findFirst([
            "conditions" => "ID = ?1 AND post_status = 'publish' AND post_type = 'post' ",
            "bind"       => [
                1 => $id,
            ]
        ]);

        if ($post){

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
             * Get categories, tags and keywords
             */
            $postTermTaxonomy =  $post->TermTaxonomy;

            $taxonomy=[];
            $coverKeywords = '';
            foreach ($postTermTaxonomy as $item){
                if ($item->taxonomy == 'category'){
                    $term = $item->Terms;
                    if ($term){
                        $taxonomy['category'][] = '<a href="' .$this->url->get(['for' => 'index-category', 'params' => $term->slug]). '" rel="category">'.$term->name.'</a>';
                    }
                }elseif ( $item->taxonomy == 'tag'){
                    $term = $item->Terms;
                    if ($term){
                        $taxonomy['tag'][] = '<a href="' .$this->url->get(['for' => 'index-tag', 'params' => $term->slug]). '" rel="tag">'.$term->name.'</a>';
                    }
                    $coverKeywords .= $term->name.','; // keywords
                }else{
                    continue;
                }
            }

            $category = implode('，',$taxonomy['category']);

            if (isset($taxonomy['tag']) && $taxonomy['tag']){
                $tag = implode('，',$taxonomy['tag']);
            }else{
                $tag = '无';
            }


            /* 静态资源 */
            $this->assets->addCss("backend/library/github-markdown-css/github-markdown.css", true); // markdown样式
            $this->assets->addCss("backend/library/highlight/styles/Github.css", true); // 代码高亮highlight主题; TODO 可配置
            $this->assets->addCss("backend/library/katex/katex.min.css", true); // 科学公式KaTeX

            $this->assets->addJs("backend/library/highlight/highlight.pack.js", true); // 代码高亮highlight
            $this->assets->addJs("backend/library/katex/katex.min.js", true); // 科学公式KaTeX
            $this->assets->addJs("themes/default/public/js/article.js", true); // 文章页面js

            /**
             * make description and keywords
             */
            if (isset($newPostMeta['description']) && !empty($newPostMeta['description'])){
                $coverDescription = $newPostMeta['description'];
            }else{
                $coverDescription = null;
            }

            if ($coverKeywords != ''){
                $coverKeywords = substr($coverKeywords, 0 , -1);
            }else{
                $coverKeywords = null;
            }

            /**
             * get last and next
             */
            $last = $post->getLastPublish();
            if ($last){
                $lastHtml = '<a href="' .$this->url->get(['for' => 'article', 'id' => $last['ID'] ]). '" rel="prev">' .$last['post_title']. '</a>';
            }else{
                $lastHtml = '';
            }
            $next = $post->getNextPublish();
            if ($next){
                $nextHtml = '<a href="' .$this->url->get(['for' => 'article', 'id' => $next['ID'] ]). '" rel="next">' .$next['post_title']. '</a>';
            }else{
                $nextHtml = '';
            }


            $post = $post->toArray();
            $markupFixer  = new \TOC\MarkupFixer();
            $tocGenerator = new \TOC\TocGenerator();
            $post['post_date'] = date('Y-m-d H:i', strtotime($post['post_date']));
            $post['post_html_content'] = $markupFixer->fix($post['post_html_content']);
            $post['toc'] = $tocGenerator->getHtmlMenu($post['post_html_content']);

            $this->view->setVars([
                'post' => $post,
                'postMeta' => $newPostMeta,
                'category' => $category,
                'tag' => $tag,
                'last' => $lastHtml,
                'next' => $nextHtml,
                'coverDescription' => $coverDescription,
                'coverKeywords' => $coverKeywords,
            ]);

        }else{
            $this->dispatcher->forward(
                [
                    "controller" => "error",
                    "action"    => "route404"
                ]
            );
        }
    }

    protected function checkViewer($post)
    {
        $id = $post->ID;

        // 检测cookie之前有没被设置过
//        if ($this->cookies->has("post_views")) {
//            // 获取cookie
//            $postCookie = $this->cookies->get("post_views");
//
//            // 获取cookie的值
//            $viewsId = json_decode($postCookie->getValue(), true);
//
//            if (!in_array($id, $viewsId)){
//
//                // 没读过
//                if ($this->redis->exists("post_views_".$id)){
//
//                    $postView = $this->redis->get("post_views_".$id);
//
//                    if( $this->redis->get('post_views_last_update_time_'.$id) < (time()-600)  ) {
//
//                        // 初始化锁参数
//                        $key = 'lockUpdateView'; //锁
//                        $random = md5( uniqid(getmypid().'_'.mt_rand().'_', true) ); //随机值
//                        $lifetime = 10; // 有效时间，单位秒
//
//                        if (!$this->redis->exists($key)){
//                            $this->redis->set($key, $random, $lifetime); // 加锁
//
//                            // 执行浏览量添加操作
//                            if( $post->updateView() ) { // 操作成功
//                                $this->redis->delete($key); // 删除锁
//                                $this->redis->set('post_views_last_update_time_'.$id, time());
//                            }
//
//                            //加入随机值判断是为了避免删除到其他操作的锁
//                            if($this->redis->get($key) == $random) {
//                                $this->redis->delete($key); // 删除锁
//                            }
//                        }
//                    }else{
//
//                    }
//                }
//            }
//        }else{
//            $this->cookies->set(
//                "post_views",
//                "some value",
//                time() + 86400
//            );
//        }
    }

}


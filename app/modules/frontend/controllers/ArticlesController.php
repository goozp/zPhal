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
        if (!$this->view->getCache()->exists('articles-'.$id)) {
            $post = Posts::findFirst([
                "conditions" => "ID = ?1 AND post_status = 'publish' AND post_type = 'post' ",
                "bind"       => [
                    1 => $id,
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
                $this->assets->addCss("backend/library/highlight/styles/github.css", true); // 代码高亮highlight主题; TODO 可配置
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
                $post['guid'] = $this->option->get('siteurl').$post['guid'];
                $post['toc'] = $tocGenerator->getHtmlMenu($post['post_html_content']) ?: '无';

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

        $this->view->cache(
            [
                'key' => 'articles-'.$id,
            ]
        );
    }
}


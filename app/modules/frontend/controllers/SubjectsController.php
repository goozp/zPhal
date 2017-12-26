<?php
namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Subjects;

class SubjectsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("subject");

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

    public function subjectAction($parent=0)
    {
        $this->tag->prependTitle('专题' . " - ");

        // Get Breadcrumb

        $subjects = Subjects::find([
            "parent = ?1",
            "bind"       => [
                1 => $parent,
            ]
        ])->toArray();

        if ($subjects){
            foreach ($subjects as $key => $subject){
                $subjects[$key]['last_updated'] = calculateDateDiff($subject['last_updated']);
                $subjects[$key]['link'] = $this->url->get(["for"=>"subject", "params" => $subject['subject_id']]);
            }

            $this->view->setVars([
                'subjects' => $subjects,
            ]);
        }else{
            $this->dispatcher->forward(
                [
                    "controller" => "subjects",
                    "action" => "detail",
                    [
                        "params"    => $parent
                    ]
                ]
            );
        }
    }

    public function detailAction($id=0)
    {
        $subject = Subjects::findFirst([
            "subject_id = ?1",
            "bind"       => [
                1 => $id,
            ]
        ]);

        if ($subject){
            $this->tag->prependTitle($subject->subject_name . " - ");

            $posts = $this->modelsManager->createBuilder()
                ->columns("p.ID, p.post_html_content, p.post_title, p.post_date, p.guid, p.comment_count, p.view_count")
                ->from(['sr' => 'ZPhal\Models\SubjectRelationships'])
                ->leftJoin('ZPhal\Models\Posts', 'p.ID = sr.object_id', "p")
                ->where("sr.subject_id = :id: AND p.post_type = 'post' AND p.post_status = 'publish'", ["id" => $subject->subject_id])
                ->orderBy("sr.order_num ASC")
                ->getQuery()
                ->execute()
                ->toArray();

            $this->view->setVars([
                'posts' => $posts,
                'total' => count($posts),
                'subjectName' => $subject->subject_name,
                'subjectDescription' => $subject->subject_description
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

}
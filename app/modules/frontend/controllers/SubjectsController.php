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
        $this->tag->prependTitle('专题' . " - ");

        $subject = Subjects::findFirst([
            "subject_id = ?1",
            "bind"       => [
                1 => $id,
            ]
        ]);

        if ($subject){

            // TODO 
            $relations = $subject->SubjectRelation;
            $post = [];
            foreach ($relations as $item){
                $post[] = $item->Post->toArray();
            }
            print_r($post);exit;

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
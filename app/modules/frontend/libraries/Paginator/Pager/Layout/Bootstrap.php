<?php

namespace ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout;

use ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout;

/**
 * ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap
 * Pager layout that uses Twitter Bootstrap styles.
 */
class Bootstrap extends Layout
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $template = '<li><a href="{%url}">{%page}</a></li>';

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $selectedTemplate = '<li class="#"><span>{%page}</span></li>';

    /**
     * {@inheritdoc}
     *
     * @param  array  $options
     * @return string
     */
    public function getRendered(array $options = [])
    {
        $currentPage = $this->pager->getCurrentPage();
        $totalPage   = $this->pager->getLastPage();
        $totalNumber = $this->pager->count();

        $result = '<span>当前第 '.$currentPage.' 页，共 '.$totalPage.' 页，共 '.$totalNumber.' 条数据</span>
        <ul class="pagination pagination-sm no-margin pull-right">';

        $bootstrapSelected = '<li class="disabled"><span>{%page}</span></li>';
        $originTemplate = $this->selectedTemplate;
        $this->selectedTemplate = $bootstrapSelected;

        $this->addMaskReplacement('page', '&laquo;', true);
        $options['page_number'] = $this->pager->getPreviousPage();
        $result .= $this->processPage($options);

        $this->selectedTemplate = $originTemplate;
        $this->removeMaskReplacement('page');
        $result .= parent::getRendered($options);

        $this->selectedTemplate = $bootstrapSelected;

        $this->addMaskReplacement('page', '&raquo;', true);
        $options['page_number'] = $this->pager->getNextPage();
        $result .= $this->processPage($options);

        $this->selectedTemplate = $originTemplate;

        $result .= '</ul>';

        return $result;
    }
}

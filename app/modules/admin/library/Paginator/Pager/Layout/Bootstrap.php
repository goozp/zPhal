<?php

namespace ZPhal\Modules\Admin\Library\Paginator\Pager\Layout;

use ZPhal\Modules\Admin\Library\Paginator\Pager\Layout;

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
    protected $selectedTemplate = '<li class="active"><span>{%page}</span></li>';

    /**
     * {@inheritdoc}
     *
     * @param  array  $options
     * @return string
     */
    public function getRendered(array $options = [])
    {
        $result = '<ul class="pagination">';

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

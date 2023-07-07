<?php
declare(strict_types=1);

namespace Backendorf\Installment\Block;

use \Backendorf\Installment\Helper\Data;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class Script extends Template
{
    /**
     * @var Data
     */
    public Data $_helperData;

    /**
     * @param Context $Context
     * @param Data $HelperData
     * @param array $Data
     */
    public function __construct(
        Context $Context,
        Data    $HelperData,
        array   $Data = []
    )
    {
        $this->_helperData = $HelperData;
        parent::__construct($Context, $Data);
    }

    /**
     * @return string
     */
    public function getConfig(): string
    {
        return json_encode($this->_helperData->getConfig());
    }
}

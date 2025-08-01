<?php
namespace AgriCart\Hello\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use AgriCart\Hello\Helper\Data as HelperData;

class Config extends Action
{
    protected $helperData;
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        HelperData $helperData
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->helperData = $helperData;
        parent::__construct($context);
    }

    public function execute()
    {
        // To test the helper, you can echo the config values.
        // In a real scenario, you'd pass this to a block.
        if ($this->helperData->isEnabled()) {
            echo $this->helperData->getGreetingText();
        } else {
            echo "Module is disabled.";
        }
        exit; // We use exit here for simple debugging.
    }
}
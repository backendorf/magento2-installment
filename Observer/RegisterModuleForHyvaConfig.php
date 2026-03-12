<?php
declare(strict_types=1);

namespace Backendorf\Installment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;

class RegisterModuleForHyvaConfig implements ObserverInterface
{
    /**
     * @var ComponentRegistrarInterface
     */
    private $componentRegistrar;

    /**
     * @param ComponentRegistrarInterface $componentRegistrar
     */
    public function __construct(ComponentRegistrarInterface $componentRegistrar)
    {
        $this->componentRegistrar = $componentRegistrar;
    }

    /**
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $config = $observer->getData('config');
        $extensions = $config->getData('extensions') ?? [];

        $path = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Backendorf_Installment');
        
        // Remove BP since Hyva expects paths relative to the root
        $relativePaths = str_replace(BP . DIRECTORY_SEPARATOR, '', $path);

        $extensions[] = [
            'src' => $relativePaths
        ];

        $config->setData('extensions', $extensions);
    }
}

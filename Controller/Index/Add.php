<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Action;

class Add extends Action {
	public function execute() {
		$helper = $this->_objectManager->get('SY\Testimonials\Helper\Data');
		$storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');
		if($helper->getConfigValue('general/active', $storeManager->getStore()->getData('store_id')) == "1"){
			return $this->resultFactory->create(
				\Magento\Framework\Controller\ResultFactory::TYPE_PAGE
			);
		}
		else{
			$this->_forward('index', 'noroute', 'cms');
		}
	}
}
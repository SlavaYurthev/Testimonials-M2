<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;

class Testimonial extends AbstractModel {
	protected $urlInterface;
	protected $_objectManager;
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\UrlInterface $urlInterface,
		\Magento\Framework\ObjectManagerInterface $objectmanager
		){
		$this->urlInterface = $urlInterface;
		$this->_objectManager = $objectmanager;
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\Testimonials\Model\ResourceModel\Testimonial');
	}
	public function getUrl(){
		return $this->urlInterface->getUrl('testimonials/index/view', ['id'=>$this->getData('id')]);
	}
	public function afterDelete(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$directory = $this->_objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
		$io = $this->_objectManager->get('Magento\Framework\Filesystem\Io\File');
		try {
			$io->rmdir($directory->getRoot().'/media/testimonials/'.$this->getData('id').'/', true);
		} catch (\Exception $e) {}
		parent::afterDelete();
	}
}
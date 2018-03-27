<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Block\Listing;

class View extends \Magento\Framework\View\Element\Template {
	protected $_registry;
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\Registry $registry
		){
		$this->_registry = $registry;
		parent::__construct($context);
	}
	public function getItem($key = false){
		if($key){
			return $this->_registry->registry('testimonial')->getData($key);
		}
		return $this->_registry->registry('testimonial');
	}
	protected function _prepareLayout(){
		$this->pageConfig->getTitle()->set($this->getItem('title'));
		$this->getLayout()->getBlock('breadcrumbs')->addCrumb(
				'home',
				[
					'title' => __('Home'),
					'label' => __('Home'),
					'link' => $this->getUrl('')
				]
			)->addCrumb(
				'testimonials',
				[
					'title' => __('Testimonials'),
					'label' => __('Testimonials'),
					'link' => $this->getUrl('testimonials')
				]
			);
		parent::_prepareLayout();
	}
}
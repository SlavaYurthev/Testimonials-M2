<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Block;

class Listing extends \Magento\Framework\View\Element\Template {
	protected $_collection;
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\SY\Testimonials\Model\Testimonial $model
		){
		$this->_collection = $model->getCollection();
		parent::__construct($context);
	}
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	public function getCollection(){
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$pageSize = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 10;
		$this->_collection->addFieldToFilter('approve', true);
		$this->_collection->setPageSize($pageSize);
		$this->_collection->setCurPage($page);
		$this->_collection->setOrder('created', 'desc');
		return $this->_collection;
	}
	protected function _prepareLayout(){
		$this->pageConfig->getTitle()->set(__('Testimonials'));
		$this->getLayout()->getBlock('breadcrumbs')->addCrumb(
				'home',
				[
					'title' => __('Home'),
					'label' => __('Home'),
					'link' => $this->getUrl('')
				]
			);
		$pager = $this->getLayout()->createBlock(
			'Magento\Theme\Block\Html\Pager',
			'reviews.listing.pager'
		)->setAvailableLimit(
			[10=>10,15=>15,20=>20]
		)->setShowPerPage(false)->setCollection(
			$this->getCollection()
		);
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		parent::_prepareLayout();
	}
	public function getAddUrl(){
		return $this->getUrl('testimonials/index/add');
	}
}
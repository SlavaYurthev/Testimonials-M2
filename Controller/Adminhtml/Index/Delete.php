<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Controller\Adminhtml\Index;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Delete extends Action {
	protected $_resultPageFactory;
	protected $_resultPage;
	public function __construct(Context $context, PageFactory $resultPageFactory){
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}
	public function execute(){
		$id = $this->getRequest()->getParam('id');
		if($id>0){
			$model = $this->_objectManager->create('SY\Testimonials\Model\Testimonial');
			$model->load($id);
			try {
				$model->delete();
				$directory = $this->_objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
				$io = $this->_objectManager->get('Magento\Framework\Filesystem\Io\File');
				$io->rmdir($directory->getRoot().'/media/testimonials/'.$id.'/', true);
				$this->messageManager->addSuccess(__('Deleted.'));
			} catch (\Exception $e) {
				$this->messageManager->addSuccess(__('Something went wrong.'));
			}
		}
		$this->_redirect('*/*');
	}
	protected function _isAllowed(){
		return $this->_authorization->isAllowed('SY_Testimonials::index');
	}
}
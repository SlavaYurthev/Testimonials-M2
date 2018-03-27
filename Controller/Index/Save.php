<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Action;

class Save extends Action {
	public function execute() {
		$resultRedirect = $this->resultRedirectFactory->create();
		$validator = $this->_objectManager->create('Magento\Framework\Data\Form\FormKey\Validator');
		if ($validator->validate($this->getRequest())) {
			$model = $this->_objectManager->create('SY\Testimonials\Model\Testimonial');
			$model->addData($this->getRequest()->getParams());
			try {
				$model->save();
				$this->messageManager->addSuccess(__('Saved.'));
				try {
					$directory = $this->_objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
					$uploader = new \Magento\MediaStorage\Model\File\Uploader(
						'image',
						$this->_objectManager->create('Magento\MediaStorage\Helper\File\Storage\Database'),
						$this->_objectManager->create('Magento\MediaStorage\Helper\File\Storage'),
						$this->_objectManager->create('Magento\MediaStorage\Model\File\Validator\NotProtectedExtension')
					);
					$uploader->setAllowCreateFolders(true);
					$uploader->setAllowedExtensions(['jpeg','jpg','png']);
					if ($uploader->save($directory->getRoot().'/media/testimonials/'.$model->getId().'/')) {
						$filename = $uploader->getUploadedFileName();
						$model->setData('image', '/media/testimonials/'.$model->getId().'/'.$filename);
						try {
							$model->save();
						} catch (\Exception $e) {}
					}
				} catch (\Exception $e) {}
			} catch (\Exception $e) {}
		}
		return $resultRedirect->setPath('*/*/add');
	}
}
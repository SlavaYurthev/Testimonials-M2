<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Block\Adminhtml\Index;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {
	protected $_coreRegistry = null;
	public function __construct(
		\Magento\Backend\Block\Widget\Context $context,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {
		$this->_coreRegistry = $registry;
		parent::__construct($context, $data);
	}
	protected function _construct(){
		$this->_objectId = 'testimonial_id';
		$this->_blockGroup = 'SY_Testimonials';
		$this->_controller = 'adminhtml_index';
		parent::_construct();
		if ($this->_isAllowedAction('SY_Testimonials::index')) {
			$this->buttonList->remove('reset');
			$this->buttonList->update('save', 'label', __('Save Testimonial'));
			$this->buttonList->add(
				'saveandcontinue',
				[
					'label' => __('Save and Continue Edit'),
					'class' => 'save',
					'data_attribute' => [
						'mage-init' => [
							'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
						],
					]
				],
				-100
			);
		} else {
			$this->buttonList->remove('save');
		}
		if ($this->_isAllowedAction('SY_Testimonials::index')) {
			$this->buttonList->update('delete', 'label', __('Delete Testimonial'));
		} else {
			$this->buttonList->remove('delete');
		}
	}
	public function getHeaderText(){
		if ($this->_coreRegistry->registry('testimonial')->getId()) {
			return __("Edit Testimonial '%1'", $this->escapeHtml($this->_coreRegistry->registry('testimonial')->getId()));
		} else {
			return __('New Testimonial');
		}
	}
	protected function _isAllowedAction($resourceId){
		return $this->_authorization->isAllowed($resourceId);
	}
	protected function _getSaveAndContinueUrl(){
		return $this->getUrl('*/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
	}
	protected function _prepareLayout(){
		$this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('general_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'general_content');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'general_content');
				}
			};
		";
		return parent::_prepareLayout();
	}
}
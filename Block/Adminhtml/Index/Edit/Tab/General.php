<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Block\Adminhtml\Index\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
 
class General extends Generic implements TabInterface {
	protected $_wysiwygConfig;
	protected $_newsStatus;
	public function __construct(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		Config $wysiwygConfig,
		array $data = []
	) {
		$this->_wysiwygConfig = $wysiwygConfig;
		parent::__construct($context, $registry, $formFactory, $data);
	}
	protected function _prepareForm(){
		$model = $this->_coreRegistry->registry('testimonial');
		$form = $this->_formFactory->create();
 
		$fieldset = $form->addFieldset(
			'base_fieldset',
			['legend' => __('General')]
		);
 
		if ($model->getId()) {
			$fieldset->addField(
				'id',
				'hidden',
				['name' => 'id']
			);
		}
		if($model->getData('image')){
			$fieldset->addField(
				'thumbnail',
				'note',
				[
					'name' => 'thumbnail',
					'label'	=> __(''),
					'required' => false,
					'note' => '<div>
						<a href="'.$model->getData('image').'" target="_blank">
							<img src="'.$model->getData('image').'" style="max-height:100px" />
						</a>
					</div>'
				]
			);
		}
		$fieldset->addField(
			'image',
			'file',
			[
				'name' => 'image',
				'label'	=> __('Image'),
				'required' => false,
				'note' => 'Allow image type: jpg, jpeg, png'
			]
		);
		$fieldset->addField(
			'author',
			'text',
			[
				'name' => 'author',
				'label'	=> __('Author'),
				'required' => true
			]
		);
		$fieldset->addField(
			'title',
			'text',
			[
				'name' => 'title',
				'label'	=> __('Title'),
				'required' => true
			]
		);
		$fieldset->addField(
			'description',
			'textarea',
			[
				'name' => 'description',
				'label'	=> __('Description'),
				'required' => true
			]
		);
		$fieldset->addField(
			'text',
			'editor',
			[
				'name' => 'text',
				'label' => __('Text'),
				'required' => true,
				'style' => 'height: 15em; width: 100%;',
				'config' => $this->_wysiwygConfig->getConfig()
			]
		);
		$fieldset->addField(
			'approve',
			'select',
			[
				'name' => 'approve',
				'label'	=> __('Approve'),
				'required' => true,
				'values' => [
					['value'=>"1",'label'=>__('Yes')],
					['value'=>"0",'label'=>__('No')]
				]
			]
		);
		$data = $model->getData();
		$form->setValues($data);
		$this->setForm($form);
 
		return parent::_prepareForm();
	}
	public function getTabLabel(){
		return __('Testimonial');
	}
	public function getTabTitle(){
		return __('Testimonial');
	}
	public function canShowTab(){
		return true;
	}
	public function isHidden(){
		return false;
	}
}
<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Block\Add;

class Form extends \Magento\Framework\View\Element\Template {
	protected $formKey;
	protected $wysiwyg;
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\Data\Form\FormKey $formKey,
			\Magento\Cms\Model\Wysiwyg\Config $wysiwyg
		){
		$this->formKey = $formKey;
		$this->wysiwyg = $wysiwyg;
		parent::__construct($context);
	}
	public function getWysiwygConfig(){
		$config = $this->wysiwyg->getConfig();
		$config->setData('add_variables', false);
		$config->setData('add_widgets', false);
		$config->setData('height', '250px');
		$config->addData([
				'settings' => [
					'mode' => 'textarea',
					'theme_advanced_buttons1' => "bold,italic,justifyleft,justifycenter,justifyright,|,fontselect,fontsizeselect,|,forecolor,backcolor,|,link,unlink,|,bullist,numlist,|,code",
					'theme_advanced_buttons2' => NULL,
					'theme_advanced_buttons3' => NULL,
					'theme_advanced_buttons4' => NULL,
					'theme_advanced_statusbar_location' => NULL
				]
			]);
		return $config;
	}
	public function getFormKey(){
		return $this->formKey->getFormKey();
	}
	protected function _prepareLayout(){
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
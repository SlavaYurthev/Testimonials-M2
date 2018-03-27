<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Model\ResourceModel\Testimonial;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(
			'SY\Testimonials\Model\Testimonial',
			'SY\Testimonials\Model\ResourceModel\Testimonial'
		);
	}
}
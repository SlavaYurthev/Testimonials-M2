<?php
/**
 * Testimonials
 * 
 * @author Slava Yurthev
 */
namespace SY\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb {
	protected function _construct() {
		$this->_init('sy_testimonials', 'id');
	}
}
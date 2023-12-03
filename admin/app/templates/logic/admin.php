<?php

define('__DROOT__', explode('/admin', __ROOT__)[0]);
define('__DHROOT__', str_replace($_SERVER['DOCUMENT_ROOT'], '', __DROOT__));

//load template parts
$this->add_logic('main', 'template');
$this->add_logic('admin/menu', 'template');
$this->styles->add(__ROOT__.'/app/templates/styles/admin.css');
$this->scripts->add(__ROOT__.'/app/templates/scripts/admin.js');
<?php 
/**
	Admin Page Framework v3.8.13 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/presscode>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class Pcode_AdminPageFramework_Form_Model___FieldTypeRegistration extends Pcode_AdminPageFramework_FrameworkUtility {
    public function __construct(array $aFieldTypeDefinition, $sStructureType) {
        $this->_initialize($aFieldTypeDefinition, $sStructureType);
    }
    private function _initialize($aFieldTypeDefinition, $sStructureType) {
        if (is_callable($aFieldTypeDefinition['hfFieldSetTypeSetter'])) {
            call_user_func_array($aFieldTypeDefinition['hfFieldSetTypeSetter'], array($sStructureType));
        }
        if (is_callable($aFieldTypeDefinition['hfFieldLoader'])) {
            call_user_func_array($aFieldTypeDefinition['hfFieldLoader'], array());
        }
    }
}

<?php

/**
 * Description of ${name}
 *
 * @author ${user}
 */
class ${name} <#if parentPresenter != "">extends ${parentPresenter} </#if>{
<#if generateStartup>

	/**
	 * (non-phpDoc)
	 *
	 * @see Nette\Application\Presenter#startup()
	 */
	protected function startup() {
		parent::startup();
	}</#if>
    <#list actions as action>
    <#if action.action>

	public function action${action.name?cap_first}() {

	}
    </#if>
    <#if action.render>

	public function render${action.name?cap_first}() {

	}
    </#if>
    </#list>
        
}
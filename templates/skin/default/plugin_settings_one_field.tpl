
	{if in_array($oParameter->getType(), array('integer', 'string', 'float', 'array', 'boolean'))}
	
		{include file="{$aTemplatePathPlugin.admin}field_forms/one_field_{$oParameter->getType()}.tpl"}
  
	{else}
		<div class="UnknownParamType">
			{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$oParameter->getType()}</b>.
		</div>
	{/if}

	type: <b>{$oParameter->getType()}</b>

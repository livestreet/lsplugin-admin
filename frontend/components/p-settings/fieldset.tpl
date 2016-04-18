{$component = 'p-settings-fieldset'}
{component_define_params params=[ 'section', 'formid' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Есть ли имя раздела (плагины могут не указывать имя раздела) *}
    {if $section->getName()}
        <h2 class="{$component}-title">{$section->getName()}</h2>
    {/if}

    {* Есть ли описание раздела (плагины могут не указывать описание раздела) *}
    {if $section->getDescription()}
        <div class="{$component}-desc">
            {$section->getDescription()}
        </div>
    {/if}

    {* Ключи раздела *}
    {if Config::Get('plugin.admin.settings.show_section_keys')}
        {$keys = $section->getAllowedKeys()}

        {if $keys}
            {$text = 'Ключи, которые показываются для данного раздела: <strong>'}

            {foreach $keys as $key}
                {$text = $text|cat:"{$key}{if ! $key@last}, {/if}"}
            {/foreach}

            {$text = $text|cat:"</strong>"}

            {component 'admin:alert' text=$text mods='info'}
        {/if}
    {/if}

    {* По всем параметрам раздела *}
    {foreach $section->getSettings() as $parameter}
        {$settingsExist = true}
        {$type = $parameter->getType()}
        {$validator = $parameter->getValidator()}
        {$name = "Settings_Sec{$sectionIteration}_Num{$parameter@iteration}[]"}

        {if in_array($type, array('array', 'integer', 'boolean', 'string', 'float'))}
            {if $type == 'string' && $validator['type'] == 'Enum'}
                {$type = 'enum'}
            {/if}
            {component 'admin:p-settings' template="field-{$type}" classes='js-settings-field' parameter=$parameter name=$name key=$parameter->getKey() formid=$formid}
        {else}
            {component 'admin:alert' text="{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$parameter->getType()}</b>" mods='error'}
        {/if}
    {/foreach}
</div>
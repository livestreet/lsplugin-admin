{**
 * Skin list
 *}

{component_define_params params=[ 'skins', 'pagination', 'updates', 'type' ]}

{if $skins}
    <div class="ls-skin-list">
        {foreach $skins as $skin}
            {component 'admin:skin' skin=$skin updates=$updates}
        {/foreach}
    </div>
{/if}
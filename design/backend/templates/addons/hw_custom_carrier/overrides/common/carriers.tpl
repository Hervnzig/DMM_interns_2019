{if $capture}
{capture name="carrier_field"}
{/if}

{$skip_carriers_data=''}
{if $addons.hw_custom_carrier.hide_default_carriers=='Y'}
{$skip_carriers_data='usps,ups,swisspost,fedex,temando,dhl,can,aup'}
{/if}
{$skip_carriers=','|explode:$skip_carriers_data}

<select {if $id}id="{$id}"{/if} name="{$name}" class="{if $meta}{$meta}{/if} form-control">
    <option value="">--</option>
    {foreach from=$carriers key="code" item="carrier_data"}
    	{if !$code|in_array:$skip_carriers}
    	<option value="{$code}" {if $carrier == $code}{$carrier_name = $carrier_data.name}selected="selected"{/if}>{$carrier_data.name}</option>
    	{/if}
    {/foreach}
</select>
{if $capture}
{/capture}

{capture name="carrier_name"}
{$carrier_name}
{/capture}
{/if}
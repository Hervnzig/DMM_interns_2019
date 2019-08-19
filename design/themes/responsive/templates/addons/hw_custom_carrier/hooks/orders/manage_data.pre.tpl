<td class="left">
	{if $o.hw_custom_carrier.shipments}
		{foreach from=$o.hw_custom_carrier.shipments item=s key=k name=hw_shipments}
			<a title="{$s.name}" href="{$s.tracking_url}" target="_blank">{$s.tracking_number}</a>
			{if !$smarty.foreach.hw_shipments.last}, {/if}
		{/foreach}
	{/if}
</td>
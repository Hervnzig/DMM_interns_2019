{capture name="mainbox"}

{capture name="tabsbox"}

<form action="{""|fn_url}" method="post" name="carrier_form" enctype="multipart/form-data">
<input type="hidden" name="fake" value="1" />

{if $shippings_carrier}
<table class="table table-middle table-objects">
<thead>
<tr>
    <th width="1%">
        <span id="off_carts" alt="{__("expand_collapse_list")}" title="{__("expand_collapse_list")}" class="hidden hand cm-combinations-carts"/><span class="exicon-collapse"></span></span>
        <span id="on_carts" alt="{__("expand_collapse_list")}" title="{__("expand_collapse_list")}" class="cm-combinations-carts"><span class="exicon-expand"></span></span>    
    </th>    
    <th class="left">{__("name")}</th>
    <th width="6%">&nbsp;</th>
    <th width="10%" class="right">{__("status")}</th>
</tr>
</thead>
{foreach from=$shippings_carrier item=carrier}
<tr class="cm-row-status-{$carrier.status|lower} cm-sortable-row cm-sortable-id-{$carrier.id} cm-row-item" >
    <td>
      <span alt="{__("expand_sublist_of_items")}" title="{__("expand_sublist_of_items")}" id="on_id_{$carrier.id}" class="cm-combination-carts"><span class="exicon-expand"></span></span>
      <span alt="{__("collapse_sublist_of_items")}" title="{__("collapse_sublist_of_items")}" id="off_id_{$carrier.id}" class="hidden cm-combination-carts"><span class="exicon-collapse"></span></span>
    </td>
    <td><a id="opener_carrier_{$carrier.id}" data-ca-target-id="content_carrier_{$carrier.id}"  class="cm-dialog-auto-size hand  cm-dialog-opener  cm-ajax" href="{"shippings.carrier_update?id=`$carrier.id`"|fn_url}" data-ca-dialog-title="{__('edit')}: {$carrier.name}" title="{$carrier.name}">{$carrier.name}</a></td>
    <td>
        {capture name="tools_list"}

            <li><a data-ca-target-id="content_carrier_{$carrier.id}"  class="cm-dialog-auto-size hand  cm-dialog-opener  cm-ajax" href="{"shippings.carrier_update?id=`$carrier.id`"|fn_url}" data-ca-dialog-title="{__('edit')}: {$carrier.name}" title="{$carrier.name}">{__('edit')}</a></li>

            <li>{btn type="list" class="cm-confirm" text=__("delete") href="shippings.carrier_delete?id=`$carrier.id`"}</li>
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right">
        {include file="common/select_popup.tpl" id=$carrier.id status=$carrier.status hidden=true object_id_name="id" table="hw_custom_carrier"}
    </td>
</tr>

<tbody id="id_{$carrier.id}" class="hidden row-more">
<tr class="no-border">
    <td class="top row-gray">&nbsp;</td>
    <td colspan="3" class="top row-gray">
               <h4>{__("shippings_carrier_test")}</h4>
                <div class="sidebar-field">
                    <input class="shippings_tracking_code span4" placeholder="{__("shippings_tracking_code")}" type="text" onkeyup="hw_custom_carrier_test({$carrier.id}, this.value)" />
                </div>

                <div class="sidebar-field"><br/>
                    <strong>{__("carrier")}</strong>:&nbsp;{$carrier.name nofilter}<br />
                    <strong>{__("tracking_number")}</strong>:&nbsp;<a id="tracking_url_{$carrier.id}" target="_blank" href="#" data-url="{$carrier.tracking_url nofilter}">[TRACKING_NUMBER]</a>
                </div>
    </td>
</tr>
</tbody>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}
</form>

{literal}
<script>
function hw_custom_carrier_test(id, value){
    var href = $('#tracking_url_'+id).data('url');
    href = href.replace('[TRACKING_NUMBER]', value);
    $('#tracking_url_'+id).attr('href', href);
    $('#tracking_url_'+id).html(value);
}
$(function(){
    $('.shippings_tracking_code').on("keyup keypress", function(e) {
      var code = e.keyCode || e.which; 
      if (code  == 13) {               
        e.preventDefault();
        return false;
      }
    });
});    
</script>
{/literal}

{/capture}
{include file="common/tabsbox.tpl" content=$smarty.capture.tabsbox track=true}

{/capture}

{capture name="add_carrier"}
    {include file="addons/hw_custom_carrier/views/shippings/components/add_carrier.tpl"}
{/capture}

{capture name="import_carriers"}
    {include file="addons/hw_custom_carrier/views/shippings/components/import_carriers.tpl"}
{/capture}

{capture name="buttons"}
    {include file="common/popupbox.tpl" id="add_carrier" text=__("add_carrier") title=__("add_carrier") content=$smarty.capture.add_carrier act="general" link_class="cm-dialog-auto-size" icon="icon-plus" link_text=__('add_carrier')}
    {include file="common/popupbox.tpl" id="import_carriers" text=__("import_carriers") title=__("import_carriers") content=$smarty.capture.import_carriers act="general" link_class="cm-dialog-auto-size" icon="icon-plus" link_text=__('import_carriers')}
    {capture name="tools_list"}
            <li>{btn type="list" text=__("export_carriers") href="shippings.export_carriers"}</li>
            {*<li>{btn type="list" text=__("disable_cscart_carriers") href="shippings.disable_cscart_carriers"}</li>
            <li>{btn type="list" text=__("enable_cscart_carriers") href="shippings.enable_cscart_carriers"}</li>*}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}
{/capture}

{capture name="sidebar"}
    <div class="sidebar-row marketplace">
        <h6>{__("marketplace")}</h6>
        <p class="marketplace-link">{__("marketplace_find_more", ["[href]" => $config.resources.marketplace_url])}</p>
    </div>
{/capture}

{include file="common/mainbox.tpl" title=__('shipping_carriers') sidebar=$smarty.capture.sidebar content=$smarty.capture.mainbox buttons=$smarty.capture.buttons adv_buttons=$smarty.capture.adv_buttons}
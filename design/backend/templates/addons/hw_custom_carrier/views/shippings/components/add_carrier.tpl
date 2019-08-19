{if $carrier_data.id}
    {$id=$carrier_data.id}    
{else}
    {$id=0}
{/if}
<div id="add_carrier_container">
    <form action="{""|fn_url}" method="post" name="add_carrier_form" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="result_ids" value="add_carrier_container_container" />
        <input type="hidden" name="carrier_data[id]" value="{$id}" />

         <fieldset>

                <div class="control-group">
                    <label class="control-label cm-required" for="carrier_name_{$id}">{__("name")}</label>
                    <div class="controls">
                    <input class="span5" type="text" name="carrier_data[name]" value="{$carrier_data.name}" id="carrier_name_{$id}" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label cm-required" for="carrier_tracking_url_{$id}">{__("shippings_tracking_url")}</label>
                    <div class="controls">
                        <input class="span9" type="text" name="carrier_data[tracking_url]" value="{$carrier_data.tracking_url}" id="carrier_tracking_url_{$id}" />
                        <p style="padding:5px 0; margin:0; color:#666">{__('shippings_tracking_url_info')}</p>
                    </div>
                </div>

                {include file="common/select_status.tpl" input_name="carrier_data[status]" id="carrier_status" obj=$carrier_data hidden=true}


                <div class="control-group">
                    <label class="control-label" for="carrier_position">{__("position")}:</label>
                    <div class="controls">
                        <input type="text" name="carrier_data[position]" size="10" id="carrier_position" value="{$carrier_data.position|default:"0"}" class="input-small" />
                    </div>
                </div>                

        </fieldset>        

        <div class="buttons-container">
            {include file="buttons/save_cancel.tpl" but_name="dispatch[shippings.update_carrier]" cancel_action="close" but_text=__("save")}
        </div>
    </form>
<!--add_carrier_container--></div>
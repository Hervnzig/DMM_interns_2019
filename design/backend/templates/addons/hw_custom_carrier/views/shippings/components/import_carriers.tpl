<div class="install-addon" id="import_carriers_container">
    <form action="{""|fn_url}" method="post" name="addon_upload_form" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="result_ids" value="import_carriers_container" />
        <div class="install-addon-wrapper">
            <img class="install-addon-banner" src="{$images_dir}/addons/hw_custom_carrier/import_box.png" width="151px" height="141px" />
            <p class="install-addon-text">{__("import_carriers_text")}</p>
            {include file="common/fileuploader.tpl" var_name="carrier_xml[0]" allowed_ext="xml"}
        </div>

        <div class="buttons-container">
            {include file="buttons/save_cancel.tpl" but_name="dispatch[shippings.import_carriers]" cancel_action="close" but_text=__("upload_install")}
        </div>
    </form>
<!--import_carriers_container--></div>
{hook name="index:bottom"}
<p class="bottom-copyright class">
    {$lang.copyright} © 
    {if $smarty.const.TIME|date_format:"%Y" != $settings.Company.company_start_year}
    {$settings.Company.company_start_year}-{/if}{$smarty.const.TIME|date_format:"%Y"} 
    {$settings.Company.company_name}.  
    {$lang.powered_by} 
    <a href="https://www.cs-cart.com" target="_blank" class="underlined">
    {$lang.copyright_shopping_cart}</a>
</p>
{/hook}

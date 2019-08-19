<?php /* Smarty version Smarty-3.1.21, created on 2019-08-16 12:48:47
         compiled from "C:\xampp\htdocs\cscart\design\backend\templates\addons\hw_custom_carrier\hooks\orders\manage_data.pre.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8678196625d567bff15d9c6-82931101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a69da46c37bd6919af03fdfd33211d4a07d3aae2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cscart\\design\\backend\\templates\\addons\\hw_custom_carrier\\hooks\\orders\\manage_data.pre.tpl',
      1 => 1565948802,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '8678196625d567bff15d9c6-82931101',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'o' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5d567bff1655e9_71592251',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d567bff1655e9_71592251')) {function content_5d567bff1655e9_71592251($_smarty_tpl) {?><td class="left">
	<?php if ($_smarty_tpl->tpl_vars['o']->value['hw_custom_carrier']['shipments']) {?>
		<?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['o']->value['hw_custom_carrier']['shipments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['s']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['s']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['s']->key;
 $_smarty_tpl->tpl_vars['s']->iteration++;
 $_smarty_tpl->tpl_vars['s']->last = $_smarty_tpl->tpl_vars['s']->iteration === $_smarty_tpl->tpl_vars['s']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['hw_shipments']['last'] = $_smarty_tpl->tpl_vars['s']->last;
?>
			<a title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['s']->value['name'], ENT_QUOTES, 'UTF-8');?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['s']->value['tracking_url'], ENT_QUOTES, 'UTF-8');?>
" target="_blank"  
				style =" display: block; width: 100px; overflow: hidden; text-overflow : ellipsis;">
				<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['s']->value['tracking_number'], ENT_QUOTES, 'UTF-8');?>

			</a>
			<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['hw_shipments']['last']) {?>, <?php }?>
		<?php } ?>
	<?php }?>
</td><?php }} ?>

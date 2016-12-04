;(function($,_,undefined){"use strict";ips.controller.register('cms.admin.databases.download',{initialize:function(){this.on('click',this.launchAlert);},launchAlert:function(e){var self=this;e.preventDefault();ips.ui.alert.show({type:'confirm',message:ips.getString('cms_download_db_explain'),icon:'fa fa-download',buttons:{ok:ips.getString('cms_download_db'),cancel:ips.getString('cancel')},callbacks:{ok:function(){window.location=self.scope.attr('data-downloadURL');},}});}});}(jQuery,_));;
;(function($,_,undefined){"use strict";ips.controller.register('cms.admin.databases.form',{initialize:function(){this.on('change','[name=database_create_page]',this.toggle);this.on('change','[name=database_use_categories]',this.toggleUseCategories);this.toggle();this.toggleUseCategories();},toggleUseCategories:function(e){var label=this.scope.find('[data-lang=index_as_categories]');if($('[name=database_use_categories]:checked').val()==1)
{label.html(ips.getString('index_as_categories'));}
else
{label.html(ips.getString('index_as_records'));}},toggle:function(e){var thisToggle=$('[name=database_create_page]:checked');$.each(['details','meta'],function(i,row)
{if(thisToggle.val()=='existing')
{$('#form_header_content_page_form_tab__'+row).hide();}
else
{$('#form_header_content_page_form_tab__'+row).show();}});}});}(jQuery,_));;
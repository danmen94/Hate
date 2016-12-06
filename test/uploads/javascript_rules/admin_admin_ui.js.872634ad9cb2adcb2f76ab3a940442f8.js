;(function($,_,undefined){"use strict";ips.controller.register('rules.admin.ui.chosen',{initialize:function()
{if(typeof $.fn.chosen!='undefined')
{var scope=this.scope;scope.find('select').chosen({disable_search_threshold:10,search_contains:true,include_group_label_in_selected:false}).on('change',function(e)
{if($(this).attr('id').match(/_source$/)&&$(this).val()=='event')
{var eventArgSelect=$('#'+$(this).attr('id').replace('_source','_eventArg'));eventArgSelect.change();}});scope.on('click','.group-result',function()
{var current=$(this).next();while(current.hasClass('group-option'))
{if(!current.hasClass('result--selected'))
{current.toggle();}
current=current.next();}});setTimeout(function()
{var select=scope.find('select');if(select.attr('id').match(/_source$/))
{setTimeout(function()
{select.change();},500);}
select.change();},200);}}});}(jQuery,_));;
;(function($,_,undefined){"use strict";ips.controller.register('rules.admin.ui.tokens',{initialize:function()
{var scope=this.scope;scope.find('.tokens-toggle').click(function(){scope.find('.tokens-list').slideToggle();$(this).find('i').toggleClass('fa-caret-right fa-caret-down');});}});}(jQuery,_));;
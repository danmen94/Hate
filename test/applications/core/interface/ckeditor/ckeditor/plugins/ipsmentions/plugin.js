﻿CKEDITOR.plugins.add("ipsmentions",{init:function(d){new CKEDITOR.plugins.ipsmentions(d)}});
CKEDITOR.plugins.ipsmentions=function(d){this.currentMention=this.listenWithinMention=this.listenForAtSymbolEvent=null;this.mentionLengthAtLastResult=this.callsWithNoResults=0;this.ajaxObj=this.results=null;this.listenForAtSymbol=function(){this.listenForAtSymbolEvent=d.on("change",function(a){CKEDITOR.tools.setTimeout(function(){var a=d.getSelection();if(a.getType()==CKEDITOR.SELECTION_TEXT)for(var a=a.getRanges(!0),c=0;c<a.length;c++)a[c].collapsed&&a[c].startOffset&&(a[c].setStart(a[c].startContainer,
0),"@"==a[c].cloneContents().$.textContent.substr(-1)&&this.respondToAtSymbol(a[c]))},0,this)},this)};this.respondToAtSymbol=function(a){var b=a.cloneContents().$.textContent;if(!(1<b.length)||b.substr(-2,1).match(/\s/)){this.listenForAtSymbolEvent.removeListener();this.currentMention=new CKEDITOR.dom.element("span");this.currentMention.setText("@");if(a.endContainer instanceof CKEDITOR.dom.element){for(var c,f=a.endContainer.getChildren(),b=f.count();0<=b;b--){var e=f.getItem(b);if(e instanceof CKEDITOR.dom.text&&
"@"==e.getText()){c=e;break}}if(!c)return}else c=a.endContainer.split(a.endOffset-1);c.split(1);this.currentMention.replace(c);c=d.createRange();c.moveToPosition(this.currentMention,CKEDITOR.POSITION_BEFORE_END);d.getSelection().selectRanges([c]);this.mentionLengthAtLastResult=this.callsWithNoResults=0;this.results=$('\x3cul class\x3d"ipsMenu ipsMenu_auto ipsMenu_bottomLeft" data-mentionMenu\x3e\x3c/ul\x3e').hide();this.results.append('\x3cli class\x3d"ipsLoading ipsLoading_small" style\x3d"height: 40px"\x3e\x26nbsp;\x3c/li\x3e');
$("body").append(this.results);c=$(this.currentMention.$).offset();b=12;a.getNextEditableNode()&&(b=a.getNextEditableNode().getSize("height"));this.results.css({position:"absolute",top:c.top+b+8,left:c.left});this.listenWithinMention=d.on("key",this.listenWithinMentionEvent,this)}};this.listenWithinMentionEvent=function(a){if(27==a.data.keyCode)this.cancelMention(),this.closeResults();else if(40==a.data.keyCode||38==a.data.keyCode){var b=this.results.children("[data-selected]");b.length?(b.removeAttr("data-selected"),
40==a.data.keyCode?b.next().attr("data-selected",!0):b.prev().attr("data-selected",!0)):40==a.data.keyCode?this.results.children(":first-child").attr("data-selected",!0):this.results.children(":last-child").attr("data-selected",!0);a.cancel()}else 13==a.data.keyCode||9==a.data.keyCode?(b=this.results.children("[data-selected]"),b.length?(b.click(),a.cancel()):13==a.data.keyCode&&(this.cancelMention(),this.closeResults())):(8==a.data.keyCode&&(this.callsWithNoResults=0),CKEDITOR.tools.setTimeout(function(){if(this.currentMention.getText().length){for(var a=
d.getSelection().getRanges(),b=0;b<a.length;b++)if(!a[b].getCommonAncestor(!0,!0).equals(this.currentMention)){this.cancelMention();this.closeResults();return}var e=this.currentMention.getText().substr(1).trim();this.results.show();if(this.ajaxObj&&_.isFunction(this.ajaxObj.abort))try{this.ajaxObj.abort()}catch(g){}this.ajaxObj=ips.getAjax()(d.config.controller+"\x26do\x3dmention\x26input\x3d"+encodeURIComponent(e),{context:this}).done(function(a){a?(this.mentionLengthAtLastResult=e.length,this.results.removeClass("ipsLoading"),
this.results.html(a),this.results.children().click($.proxy(this.selectMentionResult,this))):e.length&&(this.callsWithNoResults++,3<=this.callsWithNoResults?(this.cancelMention(),this.closeResults()):this.mentionLengthAtLastResult<=e.length-5&&this.results.hide())})}else this.closeResults()},0,this))};this.selectMentionResult=function(a){a=$(a.currentTarget);this.currentMention.renameNode("a");this.currentMention.setAttribute("href",a.attr("data-mentionhref"));this.currentMention.setAttribute("contenteditable",
"false");this.currentMention.setAttribute("data-ipsHover","");this.currentMention.setAttribute("data-ipsHover-target",a.attr("data-mentionhover"));this.currentMention.setAttribute("data-mentionid",a.attr("data-mentionid"));this.currentMention.setHtml("@"+a.find('[data-role\x3d"mentionname"]').html());d.focus();a=d.createRange();a.moveToElementEditEnd(this.currentMention);d.getSelection().selectRanges([a]);this.closeResults()};this.cancelMention=function(){this.currentMention.remove(!0)};this.closeResults=
function(){this.currentMention=null;this.results.remove();this.listenWithinMention.removeListener();this.listenForAtSymbol()};this.listenForAtSymbol()};
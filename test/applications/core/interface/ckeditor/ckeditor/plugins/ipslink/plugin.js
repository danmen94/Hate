﻿CKEDITOR.plugins.add("ipslink",{icons:"ipslink",hidpi:!0,init:function(c){c.addCommand("ipsLink",{allowedContent:"a",exec:function(a){var b="",c=ips.getString("editorLinkButton"),b=ips.getSetting("baseURL")+"?app\x3dcore\x26module\x3dsystem\x26controller\x3deditor\x26do\x3dlink\x26editorId\x3d"+a.name+"\x26title\x3d"+encodeURIComponent(a.getSelection().getSelectedText()).replace(/%C2%A0/gi,"%20"),d=CKEDITOR.plugins.ipslink.getSelectedLink(a);if(d){var e=d.getAscendant("a",!0);a.getSelection().selectElement(e);
b=e.getAttribute("href");b=ips.getSetting("baseURL")+"?app\x3dcore\x26module\x3dsystem\x26controller\x3deditor\x26do\x3dlink\x26current\x3d"+encodeURIComponent(b)+"\x26editorId\x3d"+a.name+"\x26title\x3d"+encodeURIComponent(a.getSelection().getSelectedText()).replace(/%C2%A0/gi,"%20");e.equals(d)||(b+="\x26block\x3d1")}a._linkBookmarks=a.getSelection().createBookmarks();ips.ui.dialog.create({title:c,fixed:!1,url:b,forceReload:!0}).show()}});c.addCommand("ipsLinkRemove",{allowedContent:"a",exec:function(a){var b=
new CKEDITOR.style({element:"a",type:CKEDITOR.STYLE_INLINE,alwaysRemoveElement:1});a.removeStyle(b);b=new CKEDITOR.style({attributes:{ipsnoautolink:!0}});a.applyStyle(b)}});c.ui.addButton("ipsLink",{label:ips.getString("editorLinkButton"),command:"ipsLink",toolbar:"insert"});c.on("doubleclick",function(a){a=CKEDITOR.plugins.ipslink.getSelectedLink(c)||a.data.element;if(!a.isReadOnly()&&a.is("a")&&a.getAttribute("href")){var b=!1;if(1==a.getChildCount())for(var f=a.getChildren(),d=0;d<f.count();d++){var e=
f.getItem(d);if(e.$.nodeType==e.$.ELEMENT_NODE&&e.is("img")){b=!0;break}}b||(c.getSelection().selectElement(a),c.execCommand("ipsLink"))}});c.contextMenu&&(c.addMenuGroup("ipsLink"),c.addMenuItem("editIpsLink",{label:ips.getString("editorLinkButtonEdit"),icon:this.path+"icons"+(CKEDITOR.env.hidpi?"/hidpi":"")+"/ipslink.png",command:"ipsLink",group:"ipsLink"}),c.addMenuItem("removeIpsLink",{label:ips.getString("editorLinkButtonRemove"),icon:this.path+"icons"+(CKEDITOR.env.hidpi?"/hidpi":"")+"/unlink.png",
command:"ipsLinkRemove",group:"ipsLink"}),c.contextMenu.addListener(function(a){if(a.getAscendant("a",!0))return{editIpsLink:CKEDITOR.TRISTATE_OFF,removeIpsLink:CKEDITOR.TRISTATE_OFF}}))}});CKEDITOR.plugins.ipslink={getSelectedLink:function(c){var a=c.getSelection(),b=a.getSelectedElement();return b&&(b.is("a")||b.is("img"))?b:(a=a.getRanges(!0)[0])?(a.shrink(CKEDITOR.SHRINK_TEXT),c.elementPath(a.getCommonAncestor()).contains("a",1)):null}};
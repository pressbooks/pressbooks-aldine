!function(t){var n={};function e(l){if(n[l])return n[l].exports;var i=n[l]={i:l,l:!1,exports:{}};return t[l].call(i.exports,i,i.exports,e),i.l=!0,i.exports}e.m=t,e.c=n,e.d=function(t,n,l){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:l})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},e.p="",e(e.s=1)}({1:function(t,n,e){t.exports=e("eL/z")},"eL/z":function(t,n){tinymce.create("tinymce.plugins.aldine_call_to_action",{init:function(t,n){t.addButton("aldine_call_to_action",{title:aldine.call_to_action.title,icon:"icon dashicons-flag",onclick:function(){t.windowManager.open({title:aldine.call_to_action.title,body:[{type:"textbox",name:"text",label:aldine.call_to_action.text,value:aldine.call_to_action.title},{type:"textbox",name:"link",label:aldine.call_to_action.link,value:"#"}],onsubmit:function(n){t.insertContent('[aldine_call_to_action text="'+n.data.text+'" link="'+n.data.link+'"]')}})}})},createControl:function(t,n){return null}}),tinymce.PluginManager.add("aldine_call_to_action",tinymce.plugins.aldine_call_to_action)}});
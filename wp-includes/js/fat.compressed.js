var Fat={make_hex:function(r,g,b){r=r.toString(16);if(r.length==1){r="0"+r;}g=g.toString(16);if(g.length==1){g="0"+g;}b=b.toString(16);if(b.length==1){b="0"+b;}return "#"+r+g+b;},fade_all:function(_4){var a=document.getElementsByTagName("*");for(var i=0;i<a.length;i++){var o=a[i];var r=/fade-?(\w{3,6})?/.exec(o.className);if(r){if(!r[1]){r[1]="";}if(o.id){Fat.fade_element(o.id,null,_4,"#"+r[1]);}}}},fade_element:function(id,_a,_b,_c,to){if(!_a){_a=30;}if(!_b){_b=3000;}if(!_c||_c=="#"){_c="#FFFF33";}if(!to){to=this.get_bgcolor(id);}var _e=Math.round(_a*(_b/1000));var _f=_b/_e;var _10=_f;var _11=0;if(_c.length<7){_c+=_c.substr(1,3);}if(to.length<7){to+=to.substr(1,3);}var rf=parseInt(_c.substr(1,2),16);var gf=parseInt(_c.substr(3,2),16);var bf=parseInt(_c.substr(5,2),16);var rt=parseInt(to.substr(1,2),16);var gt=parseInt(to.substr(3,2),16);var bt=parseInt(to.substr(5,2),16);var r,g,b,h;while(_11<_e){r=Math.floor(rf*((_e-_11)/_e)+rt*(_11/_e));g=Math.floor(gf*((_e-_11)/_e)+gt*(_11/_e));b=Math.floor(bf*((_e-_11)/_e)+bt*(_11/_e));h=this.make_hex(r,g,b);setTimeout("Fat.set_bgcolor('"+id+"','"+h+"')",_10);_11++;_10=_f*_11;}setTimeout("Fat.set_bgcolor('"+id+"','"+to+"')",_10);},set_bgcolor:function(id,c){var o=document.getElementById(id);o.style.backgroundColor=c;},get_bgcolor:function(id){var o=document.getElementById(id);while(o){var c;if(window.getComputedStyle){c=window.getComputedStyle(o,null).getPropertyValue("background-color");}if(o.currentStyle){c=o.currentStyle.backgroundColor;}if((c!=""&&c!="transparent")||o.tagName=="BODY"){break;}o=o.parentNode;}if(c==undefined||c==""||c=="transparent"){c="#FFFFFF";}var rgb=c.match(/rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)/);if(rgb){c=this.make_hex(parseInt(rgb[1]),parseInt(rgb[2]),parseInt(rgb[3]));}return c;}};addLoadEvent(function(){Fat.fade_all();});
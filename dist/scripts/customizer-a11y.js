!function(e){var r={};function t(o){if(r[o])return r[o].exports;var n=r[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=e,t.c=r,t.d=function(e,r,o){t.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:o})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,r){if(1&r&&(e=t(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(t.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var n in e)t.d(o,n,function(r){return e[r]}.bind(null,n));return o},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},t.p="/",t(t.s=4)}({4:function(e,r,t){e.exports=t("jfXF")},jfXF:function(e,r){var t=wp.i18n.__;document.addEventListener("DOMContentLoaded",function(){function e(e,r,t){for(var o=document.querySelectorAll(e),n=0;n<o.length;n++)o[n].setAttribute(r,t)}e("div.iris-slider.iris-strip","aria-label",t("Gradient selector","pressbooks")),e(".ui-slider-handle","aria-label",t("Gradient selector","pressbooks")),function(){for(var e=document.querySelectorAll("a.iris-palette"),r=0;r<e.length;r++){var o=e[r],n=e[r].style.backgroundColor,s="";"rgb(0, 0, 0)"===n&&(s=t("Black","pressbooks")),"rgb(255, 255, 255)"===n&&(s=t("White","pressbooks")),"rgb(221, 51, 51)"===n&&(s=t("Red","pressbooks")),"rgb(221, 153, 51)"===n&&(s=t("Orange","pressbooks")),"rgb(238, 238, 34)"===n&&(s=t("Yellow","pressbooks")),"rgb(129, 215, 66)"===n&&(s=t("Green","pressbooks")),"rgb(30, 115, 190)"===n&&(s=t("Blue","pressbooks")),"rgb(130, 36, 227)"===n&&(s=t("Purple","pressbooks")),o.setAttribute("aria-label",t("Select "+s,"pressbooks"))}}()})}});
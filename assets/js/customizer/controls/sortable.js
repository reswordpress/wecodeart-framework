"use strict";wp.customize.controlConstructor["wecodeart-sortable"]=wp.customize.Control.extend({ready:function(){var i=this;i.sortableContainer=i.container.find("ul.wecodeart-sortable__list").first(),i.sortableContainer.sortable({stop:function(){i.updateValue()}}).disableSelection().find("li").each(function(){jQuery(this).find("i.visibility").click(function(){jQuery(this).toggleClass("dashicons-visibility-faint").parents("li:eq(0)").toggleClass("invisible")})}).click(function(){i.updateValue()})},updateValue:function(){var i=[];this.sortableContainer.find("li").each(function(){jQuery(this).is(".invisible")||i.push(jQuery(this).data("value"))}),this.setting.set(i)}});
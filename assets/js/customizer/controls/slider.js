"use strict";wp.customize.controlConstructor["wecodeart-slider"]=wp.customize.Control.extend({ready:function(){var t=this;jQuery("input[type=range]").on("input change",function(){var e=jQuery(this).attr("value"),t=jQuery(this).closest(".wecodeart-slider__wrapper").find(".wecodeart-slider__number-input");t.val(e),t.change()}),jQuery(".wecodeart-slider__reset").click(function(){var e=jQuery(this).closest(".wecodeart-slider__wrapper"),t=e.find("input[type=range]"),r=e.find(".wecodeart-slider__number-input"),n=t.data("reset_value");t.val(n),r.val(n),r.change()}),this.container.on("input change","input[type=number]",function(){var e=jQuery(this).val();jQuery(this).closest(".wecodeart-slider__wrapper").find("input[type=range]").val(e),t.setting.set(e)})}});
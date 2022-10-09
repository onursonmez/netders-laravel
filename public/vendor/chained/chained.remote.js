/* jshint -W098 */

/*
* Chained - jQuery / Zepto chained selects plugin
*
* Copyright (c) 2010-2013 Mika Tuupola
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Project home:
* http://www.appelsiini.net/projects/chained
*
* Version: 0.9.8
*
*/
;(function($, window, document, undefined) {
    "use strict";

    $.fn.remoteChained = function(parents, url, options) {

        var settings;
        /* New style syntax. */
        if ("object" === typeof(parents) && "undefined" !== typeof(parents.url)) {
            settings = $.extend({}, $.fn.remoteChained.defaults, parents);
        /* Still support old style syntax. */
        } else {
            settings = $.extend({}, $.fn.remoteChained.defaults, options);
            settings.parents = parents;
            settings.url = url;
        }

        return this.each(function() {

            /* Save this to self because this changes when scope changes. */
            var self = this;
            var backup = $(self).clone();

            /* Handles maximum two parents now. */
            $(settings.parents).each(function() {
                $(this).bind("change", function() {

                    /* Build data array from parents values. */
                    var data = {};
                    $(settings.parents).each(function() {
                        var id = $(this).attr(settings.attribute);
                        var value = $(":selected", this).val();
                        data[id] = value;

                        /* Optionally also depend on values from these inputs. */
                        if (settings.depends) {
                            $(settings.depends).each(function() {
                                /* Do not include own value. */
                                if (self !== this) {
                                    var id = $(this).attr(settings.attribute);
                                    var value = $(this).val();
                                    data[id] = value;
                                }
                            });
                        }
                    });

                    $.getJSON(settings.url, data, function(json) {
                        build.call(self, json);
                        /* Force updating the children. */
                        $(self).trigger("change");
                    });
                });

                /* If we have bootstrapped data given in options. */
                if (settings.bootstrap) {
                     build.call(self, settings.bootstrap);
                     settings.bootstrap = null;
                 }
            });

            /* Build the select from given data. */
            function build(json) {
                /* If select already had something selected, preserve it. */
                var selected_key = $(":selected", self).val();

                /* Clear the select. */
                $("option", self).remove();

                var option_list = [];
                if ($.isArray(json)) {
                    /* JSON is already an array (which preserves the ordering of options) */
                    /* [["","--"],["series-1","1 series"],["series-3","3 series"]] */
                    option_list = json;
                } else {
                    /* JSON is an JavaScript object. Rebuild it as an array. */
                    /* {"":"--","series-1":"1 series","series-3":"3 series"} */
					//alert(JSON.stringify(item));

                    for (var index in json) {
                        if (json.hasOwnProperty(index)) {
                            option_list[index] = [json[index]['id'], json[index]['name']];
                        }
                    }
                }
                /* Add new options from json. */
                for (var i=0; i!==option_list.length; i++) {
                    var key = option_list[i].id;
                    var value = option_list[i].name;

                    /* Set the selected option from JSON. */
                    if ("selected" === key) {
                        selected_key = value;
                        continue;
                    }

                    var option = $("<option />").val(key).append(value);
                    $(self).append(option);
                    /*
                    if(settings.remove && key == settings.remove){
                    	//
                    } else {
	                    $(self).append(option);
                    }
                    */
                }

                /* Loop option again to set selected. IE needed this... */
                $(self).children().each(function() {
                    
                    if ($(this).val() === selected_key || $(this).val() == settings.selected || $(self).attr('data-id') == $(this).val()) {
                        $(this).attr("selected", "selected");
		                if(settings.parse){
			                $(settings.parse).html($(this).text());
		                }
                    }
                });

                /* If we have only the default value disable select. */
                if (1 === $("option", self).length && ($(self).val() == "0" || $(self).val() === "")) {
                    $(self).attr("disabled", "disabled");
                } else {
                    $(self).removeAttr("disabled");
                }

                if($('#' + $(this).attr('id')).hasClass('select2')){
					$('#' + $(this).attr('id')).select2('destroy');
					$('#' + $(this).attr('id')).select2({
                        theme: 'bootstrap4',
                        width: '100%',
                    });
				}

            }
        });
    };

    /* Alias for those who like to use more English like syntax. */
    $.fn.remoteChainedTo = $.fn.remoteChained;

    /* Default settings for plugin. */
    $.fn.remoteChained.defaults = {
        attribute: "data-name",
        depends : null,
        bootstrap : null
    };

})(window.jQuery || window.Zepto, window, document);

;(function($, window, document, undefined) {
  
    /* Init */
    function HooAddons() {} 
    $.extend(HooAddons.prototype, {
        init: function() {
            this.initWidgets()
        },
        initWidgets: function() {
            var widgetinit = this;
            $( window ).on( 'elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-accordion.default', widgetinit.widgetAccordion )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-alert.default', widgetinit.widgetAlert )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-audio.default', widgetinit.widgetAudio )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-chart-bar.default', widgetinit.widgetChart )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-flipbox.default', widgetinit.widgetFlipbox )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-image-compare.default', widgetinit.widgetImageCompare )
                elementorFrontend.hooks.addAction( 'frontend/element_ready/hoo-addons-modal.default', widgetinit.widgetModal )
                
            } );
        },
        widgetAccordion: function($scope, $){
            $scope.find('.panel-heading').on('click', function(e) {
                var toggle = $(this).find('a.accordion-toggle')
                var panelid = toggle.attr('aria-controls')
                var accordion = $scope.find('.ha-accordion')
                var next = $(panelid);
                next.slideToggle('fade');
                if (toggle.hasClass('collapsed')){
                    toggle.removeClass('collapsed')
                }else{
                    toggle.addClass('collapsed')
                }
                accordion.find('.panel-collapse').not(next).slideUp('fast')
                accordion.find('.accordion-toggle').not(toggle).addClass('collapsed')
                return false
            })
        },
        widgetAlert: function(){
            $('.ha-alert .close').on('click', function(e) {
                $(this).parent('.ha-alert').hide()
            })
        },
        widgetAudio: function(){
            
        },
        widgetChart: function($scope, $){
            var chart_bar = $scope.find('.ha-chart-bar');
            var ctx = chart_bar.get(0).getContext('2d');
            var id = chart_bar.attr('id');
            var barData = {
                type: "bar",
                data: {
                    labels : hooaddons_label[id],
                    datasets : hooaddons_datasets[id]
                }
            }
            new Chart(ctx, barData);
        },
        widgetFlipbox: function($scope, $){
            var ha_fb                = $scope.find('.ha-flipbox');
            var ha_fb_holder         = ha_fb.find('.ha-flipbox__holder');
            var ha_fb_front_height   = ha_fb.find(".ha-flipbox__front .ha-flipbox__content").height()
            var ha_fb_back_height    = ha_fb.find(".ha-flipbox__back .ha-flipbox__content").height()

            if(ha_fb_back_height > ha_fb_front_height){
                ha_fb_holder.css("min-height",ha_fb_back_height)
            }else{
                ha_fb_holder.css("min-height",ha_fb_front_height)
            }
        },
        widgetImageCompare: function($scope, $){
            var image_compare = $scope.find(".ha-image-compare");
            var default_offset_pct = image_compare.data('pct')
            var orientation = image_compare.data('orientation')
            var before_label = image_compare.data('before')
            var after_label = image_compare.data('after')

            image_compare.twentytwenty({
                default_offset_pct: default_offset_pct,
                orientation: orientation,
                before_label: before_label,
                after_label: after_label,
                click_to_move:true
            });
        },
        widgetModal:function($scope, $){

            var $modalElem = $scope.find(".ha-modal-container"),
            settings = $modalElem.data("settings"),
            $modal = $modalElem.find(".ha-modal-modal-dialog");

            if (settings.trigger === "pageload") {
                $(document).ready(function ($) {
                    setTimeout(function () {
                        $modalElem.find(".ha-modal-modal").modal();
                    }, settings.delay * 1000);
                });
            }

            if ($modal.data("modal-animation") && " " != $modal.data("modal-animation")) {
                var animationDelay = $modal.data('delay-animation');
                var waypoint = new Waypoint({
                    element: $modal,
                    handler: function () {
                        setTimeout(function () {
                            $modal.css("opacity", "1"),
                                $modal.addClass("animated " + $modal.data("modal-animation"));
                        }, animationDelay * 1000);
                        this.destroy();
                    },
                    offset: Waypoint.viewportHeight() - 150,
                });
            }
        }

    })
    $(function() {
        var hoo_addons = new HooAddons()
        hoo_addons.init()
    })
})(window.jQuery, window, document);
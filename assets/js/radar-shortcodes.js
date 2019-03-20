jQuery(window).on("load resize scroll",function(e){
    "use strict";
});

(function($) {

    // SHORTCODE TOGGLE
    $('.tabs a').click(function(){
        switch_tabs($(this));
    });

    switch_tabs($('.defaulttab'));

    function switch_tabs(obj) {
        $('.tab-content').hide();
        $('.tabs a').removeClass("selected");
        var id = obj.attr("rel");
        $('#'+id).show();
        obj.addClass("selected");
    }

    // CONTENT TOGGLE
    $('ul.accordion > li > .accordion-content').hide();

    $('.toggle').click(function(e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li > .accordion-content').removeClass('show');
            $this.next().slideToggle(350);
        }
    });

})(jQuery);

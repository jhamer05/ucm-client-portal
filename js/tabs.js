jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        //jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
        //jQuery('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
        jQuery('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
        
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});
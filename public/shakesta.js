
function confirm_delete() {
	return confirm("Are you sure about deleting this?");
}

// restfulizer.js

/**
 * Restfulize any hiperlink that contains a data-method attribute by
 * creating a mini form with the specified method and adding a trigger
 * within the link.
 * Requires jQuery!
 *
 * Ex:
 *     <a href="post/1" data-method="delete">destroy</a>
 *     // Will trigger the route Route::delete('post/(:id)')
 * 
 */
$(function(){
    $('[data-method]').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
        "   <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
        "</form>\n"
    })
    .removeAttr('href')
    .attr('style','cursor:pointer;')
    .attr('onclick','$(this).find("form").submit();');
});

//client side datepicker
$('.datetime_field').datetimepicker({
    startDate:'+2014/01/01',
    format:'Y-m-d H:i:s'
});

$(document).ready(function() {
    $('#enter-categories-select').change(function() {
        // hide or show the enter your own category options
        // css({'visibility':'visible', 'dispaly':'block'});
        // alert($('#enter-categories-select option:selected').text());
        if ($('#enter-categories-select option:selected').text() == '(other: enter your own)') {
            $('#enter-your-own-category-row').show();
            $('#other_new_category').attr('enabled','enabled').removeAttr('disabled');
        } else {
            $('#enter-your-own-category-row').hide();
            $('#other_new_category').attr('disabled','disabled').removeAttr('enabled');
        }
    });
});
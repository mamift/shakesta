
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


$(document).ready(function() {
    //client side datepicker
    $('.datetime_field').datetimepicker({ 
        format: 'Y-m-d H:i:s',
        // startDate: '+2014-05-01',
        todayButton: true,
        yearStart: 2010,
        yearEnd: 2020,
        defaultSelect: true
    });

    // $('#expires_time').datetimepicker({

    // });
    
    // $('#begins_time').datetimepicker({

    // });

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

    if ($('#registration-form #retailer_id option:selected').val() == '(other: enter your own)') {
        $('#registration-form #suggested_retailer_name').show();
        $('#registration-form #suggested_retailer_name').attr('enabled','enabled').removeAttr('disabled');
    }

    $('#registration-form #retailer_id').change(function() {
        // alert('test');
        if ($('#registration-form #retailer_id option:selected').val() == '(other: enter your own)') {
            $('#registration-form #suggested_retailer_name').show();
            $('#registration-form #suggested_retailer_name').attr('enabled','enabled').removeAttr('disabled');
        } else {
            $('#registration-form #suggested_retailer_name').hide();
            $('#registration-form #suggested_retailer_name').attr('disabled','disabled').removeAttr('enabled');
        }
    });

    $('.hidden-form').hide();
});

function change_select_category_to_update(category) {
    $('#cat_to_update').val(category);
}
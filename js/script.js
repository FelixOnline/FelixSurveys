/* Author:

*/
$(document).ready(function() {
    var dependant = [];

    dependant.find = function(needle, answer) {
        var output = [];
        $.each(dependant, function(key, value) {
            if(value.id == needle) {
                output.push(value.element);
            }
        });
        return output;
    };

    $.each($('.dependant'), function(key, value) {
        dependant.push({ id: $(value).data('dependant'), answer: $(value).data('answer'), element: value});
    });

    $('input, select').change(function(event) {
        console.log(this);
        var questions = dependant.find($(this).parents('fieldset').attr('id'));
        $.each(questions, function(key, value) {
            $(value).css('visibility', 'visible').fadeIn(200);
        });
    });
});



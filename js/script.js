/* Author:

*/
$(document).ready(function() {
    var dependant = [];

    dependant.find = function(needle, answer) {
        var output = [];
        $.each(dependant, function(key, value) {
            if(value.id == needle) {
                if(answer) {
                    if(value.answer == answer) {
                        output.push(value.element);
                    }
                } else {
                    output.push(value.element);
                }
            }
        });
        return output;
    };

    $.each($('.dependant'), function(key, value) {
        dependant.push({ id: $(value).data('dependant'), answer: $(value).data('answer'), element: value});
    });

    $('input, select').change(function(event) {
        var answer;
        switch(this.tagName) {
            case 'SELECT':
                answer = $(this).find('option:selected').val();
                break;
            case 'INPUT':
                answer = $(this).val();
                break;
        }

        /*
         * Reset all dependant questions
         */
        $.each(dependant.find($(this).parents('fieldset').attr('id')), function(key, value) {
            $(value).hide();
        });

        var questions = dependant.find(
            $(this).parents('fieldset').attr('id'), 
            answer
        );

        $.each(questions, function(key, value) {
            $(value).css('visibility', 'visible').fadeIn(200);
        });
    });

    $("a[rel=popover]")
    .popover()
    .click(function(e) {
        e.preventDefault()
    });
});


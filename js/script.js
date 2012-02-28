/* Author:

*/
$(document).ready(function() {
    var dependant = [];

    dependant.find = function(needle, answer) {
        var output = [];
        $.each(dependant, function(key, value) { // loop through all dependant questions
            if(answer) { // if an answer provided
                var satisfied = [];
                $.each(value.dependencies, function(i, dep) {
                    if(needle == dep.id) {
                        if(value.reverse == true) {
                            if(answer != dep.value) {
                                dep.satisfied = true;
                            } else {
                                dep.satisfied = false;
                            }
                        } else {
                            if(answer == dep.value) {
                                dep.satisfied = true;
                            } else {
                                dep.satisfied = false;
                            }
                        }
                    }
                    if(dep.satisfied == true) {
                        satisfied.push(dep);
                    }
                });
                if(compare(satisfied, value.dependencies)) {
                    output.push(value.element);
                }
            } else { // return all matching elements
                $.each(value.dependencies, function(i, dep) {
                    if(needle == dep.id) {
                        output.push(value.element);
                        dep.satisfied = false;
                    }
                });
            }
        });
        return output;
    };

    function compare(x,y) {
        if (x.length != y.length) { return false; }
        var a = x.sort(),
            b = y.sort();
        for (var i = 0; y[i]; i++) {
            if (a[i] !== b[i]) {
                return false;
            }
        }
        return true;
    };

    $.each($('.dependant'), function(key, value) {
        var dependencies = $(value).data('dependencies');
        if(dependencies) {
            var obj = {
                dependencies: dependencies,
                element: value
            }
            if($(value).data('reverse')) {
                obj.reverse = true;
            }
            dependant.push(obj);
        }
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
            $(value).fadeOut(200);
        });

        var questions = dependant.find(
            $(this).parents('fieldset').attr('id'), 
            answer
        );

        $.each(questions, function(key, value) {
            $(value).css('visibility', 'visible').fadeIn(200);
        });
    });

    /*
     * On load trigger change event on all inputs
     */
    $.each($('input, select'), function(key, value) {
        $(value).trigger('change');
    });

    $("a[rel=popover]")
    .popover()
    .click(function(e) {
        e.preventDefault()
    });
});


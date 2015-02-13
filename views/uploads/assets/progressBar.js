/*global $, jQuery, alert, baseUrl*/
$(document).ready(function () {
    "use strict";
    var start, ajaxReq, arrFirms = [], listFirms = '', flagProc = 0, i = 0;
    $("#test_button").click(function () {
        $("input[name='checkbox_list_name[]']:checked").each(function () {
            arrFirms.push($(this).val());
        });
        start();
    });

    start = function () {
        switch (flagProc) {
            case 0:
                if (i < arrFirms.length) {
                    listFirms = '/f0' + '/' + arrFirms[i];
                }
                ajaxReq();
                break;
            case 1:
                if (i < arrFirms.length - 1) {
                    i++;
                    flagProc = 0;
                    start();
                }
                break;
        }
    };

    ajaxReq = function () {
        $.ajax({
            type: "GET",
            url: baseUrl + listFirms,
            success: function (val) {
                var obj = $.parseJSON(val);

                listFirms = '';

                if (obj.counter === 0) {
                    $("input[name='checkbox_list_name[]'][value=" + obj.name + "]").prop('checked', 1);
                    $('#myProgress').progressbar("option", "value", 100);
                    alert("Ошибка при обработке " + obj.name);
                    flagProc = 1;
                    start();
                }
                else {
                    $("input[name='checkbox_list_name[]'][value=" + obj.name + "]").prop('checked', 0);

                    $('#checkbox_list_name_all').prop('checked', !jQuery("input[name='checkbox_list_name[]']:not(:checked)").length);

                    if (obj.counter <= 100) {
                        $('#myProgress').children('div').text(obj.counter + '%' + ' ' + obj.name);
                        $('#myProgress').progressbar("option", "value", obj.counter);
                        ajaxReq();
                    }
                    else {
                        $('#myProgress').children('div').text(100 + '%');
                        $('#myProgress').progressbar("option", "value", 100);
                        $("input[name='checkbox_list_name[]'][value=" + obj.name + "]").next().css("color","blue");
                        flagProc = 1;
                        start();
                    }
                }
            }
        });
    };
}); 
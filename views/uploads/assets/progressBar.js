/* 
 * Copyright (C) 2015 evg
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$(document).ready(function () {
    $("#test_button").click(function (e) {
        arrFirms = [];
        proc=1;
        $("input[name='checkbox_list_name\[\]']:checked").each(function () {
            arrFirms.push($(this).val())
        });
        
        for (var i = 0; i < arrFirms.length; i++) {
            if(proc == 1)
            start(arrFirms[i]);
        }
    });

    function start(currFirm){
        if(cmplt == 0){
            ar(currFirm);
            currFirm="";
        }
    }
    
    function ar(curFirm) {
        $.ajax({
            type: "GET",
            url: baseUrl,
            data: {f0:curFirm},
            success: function (val) {
                var obj = $.parseJSON(val);

                if (obj.counter == 0) {
                    $("input[name='checkbox_list_name\[\]'][value=" + obj.name + "]").prop('checked', 1);
                    $('#myProgress').progressbar("option", "value", 100);
                    alert("Ошибка при обработке " + obj.name);
                    cmplt=1;
                }
                else {
                    $("input[name='checkbox_list_name\[\]'][value=" + obj.name + "]").prop('checked', 0);
                    $('#checkbox_list_name_all').prop('checked', !jQuery("input[name='checkbox_list_name\[\]']:not(:checked)").length);

                    if (obj.counter <= 100) {
                        $('#myProgress').children('div').text(obj.counter + '%' + ' ' + obj.name);
                        $('#myProgress').progressbar("option", "value", obj.counter);
                    }
                    else {
                        $('#myProgress').children('div').text(100 + '%');
                        $('#myProgress').progressbar("option", "value", 100);
                        cmplt=1;
                    }
                }
            }
        })
    }
    ;

});    
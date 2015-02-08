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
    $(document).ready(function(){
        $("#test_button").click(function(e){
            var arrFirms = [];
            var listFirms = '';
            $("input[name='checkbox_list_name\[\]']:checked").each(function(){
            arrFirms.push($(this).val())}); 
            for (var i = 0; i < arrFirms.length; i++) {
                listFirms += '/f'+i+'/'+arrFirms[i];
            }            
            var pI=window.setInterval(function(){
                $.ajax({
                    type: "GET",
                    url: baseUrl+listFirms,
                    success: function (val) {
                        var obj = $.parseJSON(val);
                    
                        $("input[name='checkbox_list_name\[\]'][value="+obj.name+"]").prop('checked', 0);
                        $('#checkbox_list_name_all').prop('checked', !jQuery("input[name='checkbox_list_name\[\]']:not(:checked)").length);
                    
                        for (var i = 0; i < arrFirms.length; i++) {
                            var localVal=obj.counter-i*100;
                            if (obj.counter-i*100 <= 100) {
                                break;
                            }    
                        }            
                    
                        if (localVal <= 100){
                            $('#myProgress').children('div').text(localVal+'%'+' '+obj.name);
                            $('#myProgress').progressbar("option", "value", localVal);	
                        }
                        else{
                            $('#myProgress').children('div').text(100+'%');
                            $('#myProgress').progressbar("option", "value", 100);
                            window.clearInterval(pI);
                        }
                        listFirms='';
                    }			
                })
            }, 1000);	
        });
    });    
$(document).ready(function ($) {

	var ArrayData = [[]] ;
	for (var i = 0 ; i < $(".tile-aqua").length ; i++){
		ArrayData[i] = [ $("#statusName-"+i).text() , Number($("#t-"+i).find(".num").attr("data-end")) ];
	}
    var chart = c3.generate({
        bindto: '#chart3',
        data: {
            columns: ArrayData,
            type: 'pie'
        }
    });



    $.ajax({
        type: "POST",
        url: site_url + "/CRM_Users/getClientData/"+$(".DateRangeData").attr("dateRange"),
        data: ({}),
        success: function (data) {
            var status=$.parseJSON(data);

            var array = [[]];
            for (var i = 0 ; i < status["CountAge"].length ; i++){
                array[i] = [ status["CountAge"][i]["title"]+"Year" ,status["CountAge"][i]["CountData"] ];
            }

            var chart = c3.generate({
                bindto: '#chart',
                data: {
                    columns: array,
                    type: 'pie'
                }
            });

            var array = [[]];
            for (var i = 0 ; i < status["CountQualify"].length ; i++){
                array[i] = [ status["CountQualify"][i]["title"] ,status["CountQualify"][i]["CountData"] ];
            }

            var chart = c3.generate({
                bindto: '#chart1',
                data: {
                    columns: array,
                    type: 'pie'
                }
            });

            var array = [[]];
            for (var i = 0 ; i < status["CountType"].length ; i++){
                array[i] = [ status["CountType"][i]["title"] ,status["CountType"][i]["CountData"] ];
            }

            var chart = c3.generate({
                bindto: '#chart2',
                data: {
                    columns: array,
                    type: 'pie'
                }
            });

            var array = [[]];
            for (var i = 0 ; i < status["CountPlace"].length ; i++){
                array[i] = [ status["CountPlace"][i]["title"] ,status["CountPlace"][i]["CountData"] ];
            }
            var chart = c3.generate({
                bindto: '#chart4',
                data: {
                    columns: array,
                    type: 'pie'
                }
            });

        }
    });
	
	
});
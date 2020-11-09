var chart_data = [12, 19, 3, 5, 2, 3];
var chart1;
var chart2;
var chart3;
var chart4;
function createGeneralChart(type, id, data) {
	c3.generate({
		bindto: '#' + id,
		data: {
			columns: data,
			type: type
		}
	});
}
var Homecharts = [];
function chartGeneral(type, id, data) {
	Homecharts[id]=c3.generate({
		bindto: '#' + id,
		data: {
			columns: data,
			type: type
		}
	});

}



function chartGeneral2(type, id, data, labls) {
	var ctx = document.getElementById(id);

	var myChart = new Chart(ctx, {
		type: type,
		data: {
			labels: labls,
			datasets: [{
				data: data,
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
}

$("#chart1").click(function () {
	var chart_pie = $("#chart1").attr("value");
	if (chart_pie == 'pie') {
		chartGeneral(chart_pie, 'myChart', chart_data)
		$("#chart1").addClass("clicked");
		$("#chart1").attr("value", "bar");


	} else {
		chartGeneral('bar', 'myChart', chart_data)
		$("#chart1").removeClass("clicked");
		$("#chart1").attr("value", "pie");

	}
});





$(".Change_Chart2").click(function ()
{
	var parent = $(this).parents(".chartParent");
	var child = $(parent).find(".chartDiv");
	var Chart_id =$($(child)[0]).attr('id');
	$(this).addClass('bg');
	$(this).siblings().removeClass("bg");

	Homecharts[Chart_id].transform('bar');
	// switch (Chart_id) {
	// 	case 'myChart1':
	// 		chart1.transform('bar');
	// 		break;
	// 	case 'myPieChart':
	// 		chart2.transform('bar');
	// 		break;
	// 	case 'myPieChart3':
	// 		chart3.transform('bar');
	// 		break;
	//
	// 	case 'myPieChart4':
	// 		chart4.transform('bar');
	// 		break;
	// 	case 'div1':
	// 		chart4.transform('bar');
	// 		break;
	// 	case 'div2':
	// 		chart4.transform('bar');
	// 		break;
	// 	case 'div3':
	// 		chart4.transform('bar');
	// 		break;
	//
	// }
});

$('.Change_Chart1').click(function () {
	var parent = $(this).parents('.chartParent');
	var child = $(parent).find('.chartDiv');
	var Chart_id =$($(child)[0]).attr('id');
	$(this).addClass('bg');
	$(this).siblings().removeClass('bg');
	 Homecharts[Chart_id].transform('pie');

	// switch (Chart_id) {
	// 	case 'myChart1':
	// 		chart1.transform('pie');
	// 		break;
	// 	case 'myPieChart':
	// 		chart2.transform('pie');
	// 		break;
	// 	case 'myPieChart3':
	// 		chart3.transform('pie');
	// 		break;
	//
	// 	case 'myPieChart4':
	// 		chart4.transform('pie');
	// 		break;
	// 	case 'div1':
	// 		chart4.transform('pie');
	// 		break;
	// 	case 'div2':
	// 		chart4.transform('pie');
	// 		break;
	// 	case 'div3':
	// 		chart4.transform('pie');
	// 		break;
	//
	//
	// }
});







// $("#chart3").click(function () {
// 	var chart_pie = $("#chart3").attr("value");
// 	if (chart_pie == 'pie') {
// 		chartGeneral(chart_pie, 'PieChart', chart_data);
// 		$("#chart3").attr("value", "bar")
// 	} else {
// 		chartGeneral('bar', 'PieChart', chart_data);
// 		$('#chart3').attr("value", "pie");
// 	}
// })
//
// $("#chart4").click(function () {
// 	var chart_pie = $("#chart4").attr("value");
// 	if (chart_pie == 'pie') {
// 		chartGeneral(chart_pie, 'Chart', chart_data);
// 		$("#chart4").attr("value", "bar")
// 	} else {
// 		chartGeneral('bar', 'Chart', chart_data);
// 		$('#chart4').attr("value", "pie");
// 	}
// })
//
//
// $("#chart5").click(function () {
// 	var chart_pie = $("#chart5").attr("value");
// 	if (chart_pie == 'pie') {
// 		chartGeneral(chart_pie, 'ChartBar', chart_data);
// 		$("#chart5").attr("value", "bar")
// 	} else {
// 		chartGeneral('bar', 'ChartBar', chart_data);
// 		$('#chart5').attr("value", "pie");
// 	}
// })
//
//
//
// $("#chart6").click(function () {
// 	var chart_pie = $("#chart6").attr("value");
// 	if (chart_pie == 'pie') {
// 		chartGeneral(chart_pie, 'ChartBar2', chart_data);
// 		$("#chart6").attr("value", "bar")
// 	} else {
// 		chartGeneral('bar', 'ChartBar2', chart_data);
// 		$('#chart6').attr("value", "pie");
// 	}
// })

function chartCard(id,num) {
	var chart = c3.generate({
		bindto: '#' + id,
		data: {
			columns: [
				['', num]
			],
			type: 'gauge'
		}
});



}




// function chartCard(id) {
// 	var ctx = document.getElementById(id);
// 	var myChart = new Chart(ctx, {
// 		data: {
// 			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
// 			datasets: [{
// 				label: '# of Votes',
// 				data: [12, 19, 3, 5, 2, 3],
// 				backgroundColor: [
// 					'rgba(255, 99, 132, 0.2)',
// 					'rgba(54, 162, 235, 0.2)',
// 					'rgba(255, 206, 86, 0.2)',
// 					'rgba(75, 192, 192, 0.2)',
// 					'rgba(153, 102, 255, 0.2)',
// 					'rgba(255, 159, 64, 0.2)'
// 				],
// 				borderColor: [
// 					'rgba(255, 99, 132, 1)',
// 					'rgba(54, 162, 235, 1)',
// 					'rgba(255, 206, 86, 1)',
// 					'rgba(75, 192, 192, 1)',
// 					'rgba(153, 102, 255, 1)',
// 					'rgba(255, 159, 64, 1)'
// 				],
// 				borderWidth: 1
// 			}]
// 		},
// 		options: {
// 			scales: {
// 				yAxes: [{
// 					ticks: {
// 						beginAtZero: true
// 					}
// 				}]
// 			}
// 		}
// })

// $("document").ready(function () {
// 	//chartCard("bar", "m_chart_daily", t);
//
//
// });

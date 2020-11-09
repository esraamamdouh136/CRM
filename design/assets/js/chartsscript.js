$(document).ready(function ($) {

	var base =$("#base").val();
	var usertype;
	var userstatus;
	$.ajax({
		type: "POST",
		url: base + "CRM_Users/getstatus",
		data: ({}),
		success: function (data) {
			var status=$.parseJSON(data);

			var chart = c3.generate({
				bindto: '#chart',
				data: {

					columns: [

						['فعال', status[0]],
						['غير فعال', status[1]],
						['في مكالمة', status[2]]//,
						// ['غير فعال منذ 30 دقيقة', status[2]]

					],

					type: 'pie',
					onclick: function (d, i) {
						usertype=2;
						if(d["id"]=="فعال")
						{
							userstatus=1;
						}
						else if(d["id"]=="غير فعال")
						{
							userstatus=2;
						}
						if(d["id"]=="في مكالمة")
						{
							userstatus=3;
						}
						// if(d["id"]=="غير فعال منذ 30 دقيقة")
						// {
						// 	userstatus=1;
						// }
						console.log(usertype);
						window.location=base+"users/status/"+usertype+"/"+userstatus;
					}
				}
			});

			var chart = c3.generate({
				bindto: '#chart2',
				data: {

					columns: [

						['فعال', status[3]],
						['غير فعال', status[4]],
						['في مكالمة', status[5]] //,
						// ['غير فعال منذ 30 دقيقة', status[6]]
					],

					type: 'pie',
					onclick: function (d, i) {
						usertype=3;
						if(d["id"]=="فعال")
						{
							userstatus=1;
						}
						else if(d["id"]=="غير فعال")
						{
							userstatus=2;
						}
						if(d["id"]=="في مكالمة")
						{
							userstatus=3;
						}

						window.location=base+"users/status/"+usertype+"/"+userstatus;

					}
				}
			});





		}
	});

	var chart = c3.generate({
		bindto: '#chart3',
		data: {
			columns: [
			],
			type: 'pie',
			onclick: function (d, i) {
				usertype=3;
				if(d["id"]=="حالات جديده")
				{
					window.location=base+"users/clientviewBydate/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}
				else if(d["id"]=="شراء")
				{
					window.location=base+"users/client/4/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}
				else if(d["id"]=="قيد الحجز")
				{
					window.location=base+"users/client/2/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}
				else if(d["id"]=="متابعه")
				{
					window.location=base+"users/client/1/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}else if(d["id"]=="الغاء متابعه"){
					window.location=base+"users/client/3/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}else if(d["id"]=="حالات جديده متاخرة"){
					window.location=base+"users/client/3/"+$("#FromDate").val()+"@"+$("#ToDate").val();
				}
				// window.location=base+"users/status/"+usertype+"/"+userstatus;

			}
		}
	});







	var Productschart = c3.generate({
		bindto: '#Productschart',
		data: {

			columns: [

				['فعال', 10],
				['غير فعال', 60],
				['في مكالمة', 30]

			],

			type: 'pie'

		}
	});
});
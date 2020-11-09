$('document').ready(function(){
	startTime();
});

var today = new Date();
today.getDate();
function checkForm(e, form) {
	var formated_Date = new Date(today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate());
	var date = $(form).find('.callDate').val();
	var d2 = new Date(date);
	if (formated_Date.getDate() > d2.getDate() || formated_Date.getDate() == d2.getDate()) {
	} else {
		alert("برجاء إختيار تاريخ صحيح");
		e.returnValue = false;
	}
}

$('document').ready(function () {
$('.datepickerDetailsPage').attr('autocomplete','off');
})
$('.datepickerDetailsPage').datetimepicker({
	format: 'yyyy-mm-dd',
	todayHighlight: true,
	startDate:today,
	autoclose: true,
	startView: 2,
	minView: 2,
	forceParse: 0,
	enableOnReadonly: false,
	pickerPosition: 'bottom-right'
});
$('document').ready(function () {
	$('.DatebakerInput').attr('autocomplete','off')
})
$('.DatebakerInput').datetimepicker({
	format: 'yyyy-mm-dd',
	todayHighlight: true,
	autoclose: true,
	startView: 2,
	minView: 2,
	forceParse: 0,
	pickerPosition: 'bottom-right'
});

var date = new Date();
var currentTime=date.getHours() +':'+date.getSeconds();
$('document').ready(function () {
	$('.timebakerInput1').attr('autocomplete','off')
})
$(".timebakerInput1").datetimepicker({
	useCurrent : false,
	ampm: true, // FOR AM/PM FORMAT
	format : 'HH:ii p',
	showMeridian: !0,
	todayHighlight: !0,
	autoclose: !0,
	startView: 1,
	minView: 0,
	maxView: 1,
	forceParse: 0,
	pickerPosition: "bottom-left"
});







function startTime() {
	var today = new Date();
	var hr = today.getHours();
	var min = today.getMinutes();
	var sec = today.getSeconds();
	ap = (hr < 12) ? '<span>AM</span>' : '<span>PM</span>';
	hr = (hr == '0') ? 12 : hr;
	hr = (hr > 12) ? hr - 12 : hr;
	//Add a zero in front of numbers<10
	hr = checkTime(hr);
	min = checkTime(min);
	sec = checkTime(sec);
	document.getElementById("clock").innerHTML = hr + ':' + min + ':' + sec + ' ' + ap ;
	var months = ['يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سيتمبر', 'اكتوبر', 'نوفمبر', 'ديسيمبر'];
	var days = ['الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعه', 'السبت'];
	var curWeekDay = days[today.getDay()];
	var curDay = today.getDate();
	var curMonth = months[today.getMonth()];
	var curYear = today.getFullYear();
	var date = '  <i class="flaticon flaticon-calendar-with-a-clock-time-tools mr-3 "></i>' + curWeekDay + ' , ' + curDay + ' ' + curMonth + ' ' + curYear +'<div class="la la-clock-o mx-3"></i>';
	document.getElementById('date').innerHTML = date;

	var time = setTimeout(function () {
		startTime()
	}, 500);
}

function checkTime(i) {
	if (i < 10) {
		i = '0'+ i;
	}
	return i;
}




function PrintElem(elem)
{
	var mywindow = window.open('', 'PRINT', 'height=400,width=600');
	var EmpName =document.getElementById('EmpName');
	var EmpNumber =document.getElementById('EmpNumber');
	var EmpNewCall =document.getElementById('EmpNewCall');
	var EmpEndCall =document.getElementById('EmpEndCall');
	var Chart1 =document.getElementById('AnswerCalls1');
	var Chart2 =document.getElementById('NoAnswerCalls1');
	var Chart3 =document.getElementById('WrongCalls1');
	var Chart4 =document.getElementById('ReservationCalls1');
	var Chart5 =document.getElementById('contractCalls1');
	var Chart6 =document.getElementById('DecontractCalls1');
	mywindow.document.write('<html><head><title>' + document.title  + '</title>');
	mywindow.document.write('</head><body>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpName.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpNumber.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpNewCall.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpEndCall.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:150px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                تم الرد</h2>'+Chart1.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:350px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                \n' +
		'                                                    لم يتم الرد </h2>'+Chart2.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:70px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                \n' +
		' ارقام خطا   </h2>'+Chart3.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:100px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'  قيد الحجز    </h2>'+Chart4.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:70px; padding: 15px;"><h2 style="text-align:right;">\n' +
		' تم التعاقد     </h2>'+Chart5.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top: 300px; padding: 15px;"><h2 style="text-align:right;">\n' +
		' الغاء التعاقد      </h2>'+Chart6.innerHTML+'</div>');
	mywindow.document.write('</body></html>');

	mywindow.document.close();
	mywindow.focus();

	mywindow.print();
	mywindow.close();

	return true;
}



function PrintElem2(elem)
{
	var mywindow = window.open('', 'PRINT', 'height=400,width=600');
	var EmpName =document.getElementById('EmpName2');
	var EmpNumber =document.getElementById('EmpNumber2');
	var EmpNewCall =document.getElementById('EmpNewCall2');
	var EmpEndCall =document.getElementById('EmpEndCall2');
	var Chart1 =document.getElementById('AnswerCalls2');
	var Chart2 =document.getElementById('NoAnswerCalls2');
	var Chart3 =document.getElementById('WrongCalls2');
	var Chart4 =document.getElementById('ReservationCalls2');
	var Chart5 =document.getElementById('contractCalls2');
	var Chart6 =document.getElementById('DecontractCalls2');
	mywindow.document.write('<html><head><title>' + document.title  + '</title>');
	mywindow.document.write('</head><body>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpName.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpNumber.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpNewCall.innerHTML+'</div>');
	mywindow.document.write('<div style="font-size: 25px; text-align:center; border: 1px solid black;">'+EmpEndCall.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:150px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                تم الرد</h2>'+Chart1.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:350px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                \n' +
		'                                                    لم يتم الرد </h2>'+Chart2.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:70px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'                                                \n' +
		' ارقام خطا   </h2>'+Chart3.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:100px; padding: 15px;"><h2 style="text-align:right;">\n' +
		'  قيد الحجز    </h2>'+Chart4.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:70px; padding: 15px;"><h2 style="text-align:right;">\n' +
		' تم التعاقد     </h2>'+Chart5.innerHTML+'</div>');
	mywindow.document.write('<div style="border: 1px solid black;margin-top:300px; padding: 15px;"><h2 style="text-align:right;">\n' +
		' الغاء التعاقد      </h2>'+Chart6.innerHTML+'</div>');
	mywindow.document.write('</body></html>');

	mywindow.document.close();
	mywindow.focus();

	mywindow.print();
	mywindow.close();

	return true;
}
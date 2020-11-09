			function date_time(id) {
				date = new Date;
				year = date.getFullYear();
				month = date.getMonth();
				months = new Array('يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر',
					'نوفمبر', 'ديسمبر');
				d = date.getDate();
				day = date.getDay();
				days = new Array('الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعة', 'السبت');
				h = date.getHours();
				var m = date.getMinutes();
				var s = date.getSeconds();
				var TimeDay = 'AM';

				if (h == 0) {
					h = 12;
				}

				if (h > 12) {
					h = h - 12;
					TimeDay = "PM";
				}

				h = (h < 10) ? "0" + h : h;
				m = (m < 10) ? "0" + m : m;
				s = (s < 10) ? "0" + s : s;
				result = '<i class="entypo-calendar"></i>' + days[day] + ' ,' + d + ' ' + months[month] + ' ' + year + '  ' +
					'<i class="entypo-clock"></i> ' + h + ':' + m + ':' + s + ' ' + TimeDay;
				document.getElementById(id).innerHTML = result;
				setTimeout('date_time("' + id + '");', '1000');
				return true;

			}

			function myFunction() {
				var input, filter, ul, li, a, i;
				input = document.getElementById("myInput");
				filter = input.value.toUpperCase();
				ul = document.getElementById("myUL");
				li = ul.getElementsByTagName("li");
				for (i = 0; i < li.length; i++) {
					a = li[i].getElementsByTagName("a")[0];
					if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
						li[i].style.display = "";
					} else {
						li[i].style.display = "none";

					}
				}
			}
			$(document).on('click', '#t36el', function () {

				if ($(this).hasClass('btn btn-danger btn-sm icon-left')) {
					$(this).removeClass("btn btn-danger btn-sm icon-left");
					$(this).addClass("btn btn-success ");
					$(this).find("span").html("تشغيل");
					$(this).parent("td").find("#t3del").attr('disabled', 'disabled');
				} else if ($(this).hasClass('btn btn-success')) {
					$(this).removeClass("btn btn-success");
					$(this).addClass("btn btn-danger btn-sm icon-left");
					$(this).find("span").html("تعطيل");
					$(this).parent("td").find('#t3del').removeAttr('disabled');
				}
			});


			function deleteRow(r) {
				var y = confirm("Are you Sure");
				switch (y) {
					case false:

						break;
					default:

						$(r).parents("tr").remove();

				}

			}

			$(document).on("click", ".delete-icon", function () {
				$(this).parents("tr").remove();
			});

			function deleteRowpopup() {

				var radio1 = document.getElementById('radio1');
				var radio2 = document.getElementById('radio2');
				if (radio1.checked || radio2.checked) {
					$('#' + $('.RowData').text()).remove();
				} else {
					alert("من فضلك اختار موظف او مشرف");
				}

			}

			function deleteRowpopup2() {

				if ($(".datepicker").val() != '' && $('#dropdown option:selected').prop('disabled') == false) {
					$('#' + $('.RowData').text()).remove();
				} else {
					alert("من فضلك حدد موظف والتاريخ");
				}

			}







			function myFunction3() {
				var table = document.getElementById("estable");
				var row = table.insertRow(1);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				// cell1.innerHTML = "<input type='button' class='remove' value='X' onclick='deleteRowMonthly(this)'>";
				//   cell2.innerHTML = "<input type='checkbox' value=''>";
				cell1.contentEditable = 'true';
				cell1.innerHTML = "NEW CELL";
				cell2.contentEditable = 'true';
				cell2.innerHTML = "NEW CELL";
				cell3.contentEditable = 'true';
				cell3.innerHTML = "NEW CELL";
				cell4.contentEditable = 'true';
				cell4.innerHTML = "NEW CELL";
				cell5.innerHTML = "<button class='btn btn-outline-danger' onclick='deleteRow(this)'> حذف</button>";
			}




			function myFunction5() {
				var table = document.getElementById("table_id2");
				var row = table.insertRow(1);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				cell1.contentEditable = 'true';
				cell1.innerHTML = "NEW CELL";
				cell2.contentEditable = 'true';
				cell2.innerHTML = "NEW CELL";
				cell3.contentEditable = 'true';
				cell3.innerHTML = "NEW CELL";
				cell4.innerHTML = "	<td><button class='btn btn-outline-danger' onclick='deleteRow(this)'> حذف</button>";
			}


			jQuery(document).ready(function ($) {



				//editFunction
				var row;
				$('#estable').on('click', 'i.entypo-pencil', function () {
					row = $(this).parents("tr");
					var code = row.find(".code").text();
					var codeInput = $("#field-1");
					codeInput.val(code);
					var price = row.find(".price1").text();
					var priceInput = $("#field-2");
					priceInput.val(price);
					var descripe = row.find(".descripe1").text();
					var descripeInput = $("#field-4");
					descripeInput.val(descripe);
					var cancel = row.find(".cancel1").text();
					alert(cancel);
					var cancelInput = $("#field-3");
					cancelInput.val(cancel);


				});
				// 	function save(){
				//    var code = row.find(".code").text();
				// 		var codeInput = $("#field-1");
				// 		code.val(codeInput);
				// 		var price = row.find(".price1").text();
				// 		var priceInput = $("#field-2");
				// 		priceInput.val(price);
				// 		var descripe = row.find(".descripe1").text();
				// 		var descripeInput = $("#field-4");
				// 		descripeInput.val(descripe);
				// 		var cancel = row.find(".cancel1").text();
				// 		alert(cancel);
				// 		var cancelInput = $("#field-3");
				// 		cancelInput.val(cancel);
				// 	}


				$(function () {
					$("#dialog").dialog({
						autoOpen: false,
						modal: true,
						buttons: {
							'حفظ': function () {
								$(".showLoading").show();
								var newImg = $("#myfileData");
								debugger;
								var data = new FormData();
								var base = $("#base").val();
								data.append('img', newImg.prop('files')[0]);

								var base = $("#base").val();
								//add td to table and attech the class names to them

								$.ajax({
									type: 'post',
									processData: false, // important
									contentType: false, // important
									datatype: "json",
									url: base + "copydata",
									data: data,
									success: function (doc) {
										if (doc == 1) {
											$(".showLoading").hide();
											alert("تم رفع البيانات بنجاح");
										} else {
											$(".showLoading").hide();
											alert("حدث خطأ أثناء عمليه رفع البيانات");
										}
									}
								});

								$(this).dialog('close');
							},

							'اغلاق': function () {

								$(this).dialog('close');
							}
						}
					});

					$("#opener").on("click", function () {
						$("#dialog").dialog("open");
					});
				});
				$("#rs2").on("click", function () {
					$("#opener-mail").dialog('close');
				});



				$(function () {
					$("#dialog2").dialog({
						autoOpen: false,

						position: {
							my: 'left',
							at: 'bottom',
							of: $('#main-menu')
						},
					});

					$("#opener2").on("click", function () {
						$("#dialog2").dialog("open");

					});
				});

				$(function () {
					$("#sendEmailsdialog").dialog({
						autoOpen: false,
						position: {
							my: 'left',
							at: 'bottom',
							of: $('#main-menu')
						}
					});

					$("#sendEmails").on("click", function () {
						$("#sendEmailsdialog").dialog("open");

					});
				});
				/**** */


				$(function () {
					$("#dialog-mail").dialog({
						autoOpen: false,
						modal: true,
						position: {
							my: 'left',
							at: 'bottom',
							of: $('#main-menu')
						},
					});

					$("#opener-mail").on("click", function () {
						$("#dialog-mail").dialog("open");
					});
				});
				/******* */
				$(function () {
					$("#dialog-message").dialog({
						autoOpen: false,
						modal: true,

						position: {
							my: 'left',
							at: 'bottom',
							of: $('#main-menu')
						},
					});

					$("#opener-message").on("click", function () {
						$("#dialog-message").dialog("open");
					});
				});




				$(function () {
					$("#dialog-message2").dialog({
						autoOpen: false,
						modal: true,

						position: {
							my: 'left',
							at: 'bottom',
							of: $('#main-menu')
						},
					});

					$("#opener-message2").on("click", function () {
						$("#dialog-message2").dialog("open");
					});
				});


				$("#checkAll").change(function () {
					$("input:checkbox").prop('checked', $(this).prop("checked"));
				});


				// $('#button11').on('click', function () {
				// 	var radio1 = document.getElementById('radio1');
				// 	var radio2 = document.getElementById('radio2');
				//
				// 	if (radio1.checked || radio2.checked) {
				//
				// 		$('td input:checked').closest('tr').remove();
				// 	} else {
				// 		alert("من فضلك اختار موظف او مشرف")
				// 	}
				//
				// });


				$('#button156').on('click', function () {

					$('td input:checked').closest('tr').remove();


				});
				$('#button1567').on('click', function () {
					if ($(".datepicker").val() != '' && $('#dropdown option:selected').prop('disabled') == false) {
						$('td input:checked').closest('tr').remove();
					} else {
						alert("من فضلك حدد التاريخ والموظف");
					}

				});
				$("#radio1").click(function () {

					$("#sel2").prop("disabled", true);
					$("#sel1").prop("disabled", false);

				});
				$("#radio2").click(function () {

					$("#sel1").prop("disabled", true);
					$("#sel2").prop("disabled", false);

				});



				$('[data-toggle="popover"],[data-original-title]').popover({
					html: 'true',
					placement: 'center center',

				});

				$('[data-toggle="popover"]').popover();

				$('body').on('click', function (e) {
					$('[data-toggle="popover"]').each(function () {
						//the 'is' for buttons that trigger popups
						//the 'has' for icons within a button that triggers a popup
						if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
							$(this).popover('hide');
						}
					});
				});

				$(function () {
					$("#dialog3").dialog({
						autoOpen: false,
						modal: true,
						buttons: {
							'حفظ': function () {
								var textValue = $('#myTextBox').val();


							},

							'اغلاق': function () {

								$(this).dialog('close');
							}
						}
					});

					$("#opener12").on("click", function () {
						$("#dialog3").dialog("open");
					});
				});



				$(function () {
					$("#dialog4").dialog({
						autoOpen: false,
						modal: true,
						buttons: {
							'حفظ': function () {
								var textValue = $('#myTextBox').val();


							},

							'اغلاق': function () {

								$(this).dialog('close');
							}
						}
					});

					$("#opener14").on("click", function () {
						$("#dialog4").dialog("open");
					});
				});
				/****************** */

				$(function () {
					$("#dialog5").dialog({
						autoOpen: false,
						modal: true,
						buttons: {
							'حفظ': function () {
								var textValue = $('#myTextBox').val();


							},

							'اغلاق': function () {

								$(this).dialog('close');
							}
						}
					});

					$("#opener5").on("click", function () {
						$("#dialog5").dialog("open");
					});
				});
				/************************ */

				$(function () {
					$("#dialog-problem").dialog({
						autoOpen: false,
						modal: true
					});

					$("#opener-problem").on("click", function () {
						$("#dialog-problem").dialog("open");
					});
				});
				/**************************** */
				$(function () {
					$("#dialog-problem2").dialog({
						autoOpen: false,
						modal: true
					});

					$("#opener-problem2").on("click", function () {
						$("#dialog-problem2").dialog("open");
					});
				});

				$('#addgroup').click(function () {


					$("#myUL").append("<li data-toggle='modal' data-target='#exampleModal1' class='item list-group-item' id='list2'><a class='item' href='#'>" + $('#name-text').val() + "</a></li>");




				});



				$('.item').click(function () {
					document.getElementById('name-text').value = $(this).text();



				});
				$(".clncheckAll").change(function () {
					$("input:checkbox").prop('checked', $(this).prop("checked"));
				});


				window.onload = function () {

					var
						userFilter, Departmentsfilter, statusFilter, milestoneFilter, priorityFilter, tagsFilter;

					function updateFilters() {
						$('.task-list-row').hide().filter(function () {
							var
								self = $(this),
								result = true; // not guilty until proven guilty


							if (Departmentsfilter && (Departmentsfilter != 'الكل')) {
								result = result && Departmentsfilter === self.data('Departments');
							}
							if (statusFilter && (statusFilter != 'الكل')) {
								result = result && statusFilter === self.data('status');
							}
							if (milestoneFilter && (milestoneFilter != 'الكل')) {
								result = result && milestoneFilter === self.data('milestone');
							}
							if (priorityFilter && (priorityFilter != 'الكل')) {
								result = result && priorityFilter === self.data('priority');
							}

							return result;
						}).show();
					}


					// Task Status Dropdown Filter
					$('#status-filter').on('change', function () {
						statusFilter = this.value;

						updateFilters();

					});
					// Task Status Dropdown Filter
					$('#Departmentsfilter').on('change', function () {
						Departmentsfilter = this.value;
						updateFilters();

					});

					// Task Milestone Dropdown Filter
					$('#milestone-filter').on('change', function () {
						milestoneFilter = this.value;
						console.log("daaaaaaaa", milestoneFilter);
						updateFilters();
					});

					// Task Priority Dropdown Filter
					$('#priority-filter').on('change', function () {
						console.log("daaaaaaaa", priorityFilter);
						priorityFilter = this.value;
						updateFilters();
					});
				}



			});
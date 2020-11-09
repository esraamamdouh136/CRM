 function myFunction() {
      var table = document.getElementById("myTable");
      var row = table.insertRow(0);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
     
      cell1.innerHTML = "<input type='button' class='remove' value='X'  onclick='deleteRow(this)'>";
      cell2.innerHTML = "<input type='checkbox' value=''>";
      cell3.innerHTML = "NEW CELL";
      cell3.contentEditable = 'true';
      cell4.innerHTML = "NEW CELL";
      cell4.contentEditable = 'true';
      cell5.innerHTML = "NEW CELL";
      cell5.contentEditable = 'true';
      cell6.innerHTML = "NEW CELL";
      cell6.contentEditable = 'true';
      cell7.innerHTML = "NEW CELL";
      cell7.contentEditable = 'true';
    }
// $(".btn-sm").click(function(){
//       debugger;
//       var y= confirm("Are you Sure");
//     switch(y)
//     {
//     case false:
//
//     break;
//     default:
//        $(this).parent().parent().remove();
//     }
//  });
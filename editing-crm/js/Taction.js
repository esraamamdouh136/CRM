var curFilterTable=$(".zadnatable");
var curAddTable=$(".zadnatable");
var crops="";
var page,table,MyRows,RowLen;
// var table=page.find('.zadnatable');
// var MyRows = table.find('tbody').find('tr');
// var RowLen=MyRows.length;



$(document).ready(function () {
    $(".zadnatable tbody ").paginate({'perPage': 5});

 $(document).on("click", ".view-row", function () {
        var row = $(this).parents("tr");
        var Rowid=row.attr("rowid");
        var modal =row.parents(".Tparent").find(".modal");
     modal.find(".close-btn").hide();
     modal.find(".savenew").hide();
     
       var save=modal.find("save-edit");
        modal.attr("viewrow",Rowid);
        var td=row.find("td");
       var inputs=$(".edit-type");
       for(var i=0,j=1 ; i<inputs.length ;i++,j++){
           $(inputs[i]).val($(td[j]).text());
       }
     
    
    
     save.click(function(){
         SaveEdit(inputs,td);
     })
     

    });
    
    function  SaveEdit(inputs,td){
            for(var i=0,j=1 ; i<inputs.length ;i++,j++){
              $(td[j]).text($(inputs[i]).val());
       }
    }
    
    


    $(document).on("click", ".export-excel", function (){
        var table = $(this).parents(".Tparent").find(".zadnatable");
        table.table2excel({
            exclude: ".actions",
            name: "Worksheet Name",
            filename: "zadnafile" //do not include extension
        });
    });


// remove row
    $('#deletemodal').on('show', function() {

        var id = $(this).data('id'),
            removeBtn = $(this).find('.danger');

    })
    var tr;
    var tableBody;
//    $('.delete-icon').on('click', function(e) {





    $(document).on("click", ".add-crepto", function () {
        crops = "";
        $("#myUL2 input").prop("checked", false);


    });


    $(document).on("click", ".addnew", function () {
        $("#EditModal-name-text-kind").val("");
        $("#name-text-kind").val("");
        $("#name-text").val("");
    });


    //add a row to table
    $(document).on("click", "#save-new", function () {
        var Table = $(".zadnatable");
        // var Rowid=Table.find("tr").attr("rowid");
        var LastId=Table.find("tbody tr:last").attr("rowid");
        var newID=parseInt(LastId) + 1;
        var cul1 = '<td>' + 33 + '</td>';
        var cul2 = '<td>' + $(".selected-value").text() + '</td>';
        var cul3 = '<td>cropData</td>';
        var cul4 = "<td class=\"query-td\"><i class=\"fas fa-trash-alt delete-icon\" title=\"Delete\"></i>\n" +
            "                            <i class=\"fas fa-eye view-row\" title=\"View\"  data-toggle=\"modal\" data-target=\"#ُEditTypeModal\"></i></td>\n";
        var row = '<tr rowid='+newID +'>' + cul1 + cul2 + cul3 + cul4 + '</tr>';
        Table.find("tbody").append(row);
        Table.find("tbody").data('paginate').kill();
        Table.find("tbody").paginate({'perPage': 5});
        $("#addTypeModal").modal("hide");

    });

    $(document).on("click", ".view-row-crops", function () {
        var row = $(this).parents("tr");
        document.getElementById("Crop_Type_ID").setAttribute("value",row.attr('data'));
        var Rowid=row.attr("rowid");
        $("#ُEditTypeModal").attr("viewrow",Rowid);
        $(".edit-type").val(row.find("td")[1].innerHTML.trim());
        $.ajax({
            type: 'post',
            datatype: "json",
            url:  window.location.origin + "/Farm/index.php/Crops/getCropTypes",
            data: {Category_ID: row.find("td")[0].innerHTML},
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['status'] == true) {
                    var ul = document.getElementById("Edit-myUL2");
                    ul.innerHTML="";
                    for(var i=0;i<Dataarray['res'].length;i++){
                        var li = document.createElement("li");
                        li.appendChild(document.createTextNode(Dataarray['res'][i][1]));
                        li.setAttribute("value", Dataarray['res'][i][0]);
                        li.setAttribute("class", "list-group-item");
                        ul.appendChild(li);
                    }
                }
            }
        });
    });






    $(document).on("click", ".view-row-users", function () {


        tr=$(this).parents("tr");
        var User_ID = tr.attr('data');

        $.ajax({
            type: 'post',
            datatype: "json",
            url:  window.location.origin + "/Farm/index.php/Users/showUserData",
            data: {UserID: User_ID},
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['status'] == true) {
                    document.getElementById('UserName').innerHTML=Dataarray['res'][0].emp_name;
                    document.getElementById('UserID').value=Dataarray['res'][0].user_id;
                    document.getElementById('Edit-user-name').value=Dataarray['res'][0].user_name;
                    document.getElementById('Edit-psw').value=Dataarray['res'][0].password;
                    if (Dataarray['res'][0].active == 0)
                        document.getElementById('Edit-status').checked = false;
                    else
                        document.getElementById('Edit-status').checked = true;
                }else{
                    alert(Dataarray['msg']);
                }
            }
        });

        var id = $(this).data('id');
        $('#viewUserModal').data('id', id).modal('show');

    });

    $(document).on("click", "#add-user", function () {
        var UserName = document.getElementById('user-name');
        var Pass = document.getElementById('psw');
        var emp_id = document.getElementById('emp_id');
        var active = document.getElementById('active');
        var UStatus = 0;
        if (active.checked)
            UStatus = 1;
        else
            UStatus = 0;
        if (UserName.value == "" || Pass.value =="" || emp_id.value <=0) {
            alert("برجاء التاكد من البيانات المدخلة");
        }else {
            $.ajax({
                type: 'post',
                datatype: "json",
                url:  window.location.origin + "/Farm/index.php/Users/createUser",
                data: {uname: UserName.value,upass :Pass.value , empid:emp_id.value,status:UStatus},
                success: function (doc) {
                    var Dataarray = $.parseJSON(doc);
                    if (Dataarray['status'] == true) {
                        alert(Dataarray['msg']);
                        location.reload();

                    }else{
                        alert(Dataarray['msg']);
                    }
                }
            });
        }
    });

    $(document).on("click", ".delete-icon-users", function (e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#deletemodal').data('id', id).modal('show');
        tr=$(this).parents("tr");
        tableBody = $(this).parents(".zadnatable").find("tbody");
        var btn_Yes = document.getElementById('user-btnYes');
        btn_Yes.setAttribute("value", tr.attr('data'));


    });

    $('#user-btnYes').click(function() {
        var User_ID = $(this).attr('value');
        // Delete User Using AJAX
        $.ajax({
            type: 'post',
            datatype: "json",
            url:  window.location.origin + "/Farm/index.php/Users/deleteUser",
            data: {userID: User_ID},
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['status'] == true) {
                    var id = $('#deletemodal').data('id');
                    $('[data-id='+id+']').remove();
                    $('#deletemodal').modal('hide');
                    tr.remove();
                    tableBody.data('paginate').kill();
                    tableBody.paginate({'perPage': 5});
                    alert(Dataarray['msg']);
                    location.reload();
                }else{
                    alert(Dataarray['msg']);
                }
            }
        });


    });

    $(document).on("click",".edit-btn-User",function () {
        var editBtn=$(this);
        var modal=editBtn.parents(".modal");
        var saveBtn=modal.find(".save-btn-User");
        var Editusername=document.getElementById("Edit-user-name");
        var Editpsw=document.getElementById("Edit-psw");
        var Editstatus=document.getElementById("Edit-status");
        editBtn.hide();
        saveBtn.attr("hidden",false);
        Editusername.disabled = false;
        Editpsw.disabled = false;
        Editstatus.disabled = false;
    });

    $('#save-btn-User').click(function() {
        var saveBtn=$(this);
        var modal=saveBtn.parents(".modal");
        var editBtn=modal.find(".edit-btn-User");
        var User_ID = document.getElementById('UserID');
        var UserName=document.getElementById("Edit-user-name");
        var Pass=document.getElementById("Edit-psw");
        var IsActive=document.getElementById("Edit-status");
        var UStatus = 0;
        if (IsActive.checked)
            UStatus = 1;
        else
            UStatus = 0;
        $.ajax({
            type: 'post',
            datatype: "json",
            url:  window.location.origin + "/Farm/index.php/Users/editUser",
            data: {userID: User_ID.value ,uname:UserName.value,upsw:Pass.value,status:UStatus},
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['status'] == true) {
                    // If ajax success
                    saveBtn.attr("hidden", true);
                    editBtn.show();
                    UserName.disabled = true;
                    Pass.disabled = true;
                    status.disabled = true;
                    toastr.success(Dataarray['msg']);
                    location.reload();
                }else{
                    toastr.error(Dataarray['msg']);
                }
            }
        });


    });

    $(document).ready(function() {
        var categoryName = document.getElementById('category_Name');
        $("#add_category").click(function () {
            $.ajax({
                type: 'post',
                datatype: "json",
                url:   window.location.origin + "/Farm/index.php/Crops/addCropsCategory",
                data: {Category_Name: categoryName.value},
                success: function (doc) {
                    var Dataarray = $.parseJSON(doc);
                    if (Dataarray['status'] == true) {
                        $("#myUL").prepend("<li ><span  class='item' value='"+Dataarray['res']+"'>" + categoryName.value + "</span> <i class='fa fa-times remove-crop-category' value='"+Dataarray['res']+"'></i> </li>");

                        toastr.success(Dataarray['msg']);
                    } else {
                        toastr.error(Dataarray['msg']);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        var TypeName = document.getElementById('Type_Name');
        var CategotyID = document.getElementById("Crop_Category_Name");
        $("#add_Type").click(function () {
            $.ajax({
                type: 'post',
                datatype: "json",
                url:  window.location.origin + "/Farm/index.php/Crops/addCropsType",
                data: {type_Name: TypeName.value, Category_ID : CategotyID.getAttribute("value")},
                success: function (doc) {
                    var Dataarray = $.parseJSON(doc);
                    if (Dataarray['status'] == true) {
                        toastr.success(Dataarray['msg']);
                        location.reload();
                    } else {
                        toastr.error(Dataarray['msg']);

                    }
                }
            });
        });
    });

    $(document).on("click", ".delete-icon-crops", function (e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#deletemodal').data('id', id).modal('show');
        tr=$(this).parents("tr");
        tableBody = $(this).parents(".zadnatable").find("tbody");
        var btn_Yes = document.getElementById('crops-btnYes');
        btn_Yes.setAttribute("value", tr.attr('data'));


    });

    $('#crops-btnYes').click(function() {
        var Crop_ID = $(this).attr('value');

        $.ajax({
            type: 'post',
            datatype: "json",
            url:  window.location.origin + "/Farm/index.php/Crops/deleteCropesCategory",
            data: {CropID: Crop_ID},
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['status'] == true) {
                    toastr.success(Dataarray['msg']);
                    // alert(Dataarray['msg']);
                    location.reload();
                }else{
                    toastr.error(Dataarray['msg']);
                    // alert(Dataarray['msg']);
                }
            }
        });


    });


    $(document).on("click", ".edit-btn-crop", function () {
        var editBtn=$(this);
        var modal=editBtn.parents(".modal");
        var saveBtn=modal.find(".save-btn-crop");
        var type=modal.find(".edit-type");
        var listItem=modal.find("#add-categ li");
        editBtn.hide();
        saveBtn.attr("hidden",false);
        listItem.attr("contenteditable",true);
        listItem.css("border",".5px solid gray");
        type.attr("disabled",false);

    });





    $(document).on("click",".close-btn-edit ,.close-edit",function () {
        var closeBtn=$(this);
        var modal=closeBtn.parents(".modal");
        var saveBtn=modal.find(".save-btn-crops");
        var editBtn=modal.find(".edit-btn");
        var type=modal.find(".edit-type");
        var listItem=modal.find("#add-categ li");
        editBtn.show();
        saveBtn.attr("hidden",true);
        listItem.attr("contenteditable",false);
        type.attr("disabled",true);
    });





    $('#EditModal-add-item').click(function () {


        if ($("#EditModal-name-text-kind").val()== '')
        {

        }else
            $("#Edit-myUL2").append("<li class='list-group-item'>" +
                $('#EditModal-name-text-kind').val() + "</li>");



    });



    // $(".filter-form").addEventListener('click', intial);

    $(".filter-search-box").one("click", function(){
        intial($(this));
    });


    $(".filter1").on("change",function () {
        var data= $(this).val();
        filter(data);

    });

    $(".filter3").on("change",function () {
        filter3();

    })

    $(".filter2").on("change",function () {
        filter2($(".box1"),$(".box2"));

    })



});

function intial(box) {
    // alert("clicked");
    page=box.parents('.Tparent');
    table=page.find('.zadnatable');
    MyRows = table.find('tbody').find('tr');
    RowLen=MyRows.length;
}



function filter(data) {
    // $(".table tbody tr").remove();
    var TBody=table.find("tbody");
    table.find("tbody tr").remove();
    TBody.data('paginate').kill();
    var result=false;
    var found=false;



    // for (var i = 0; i < RowLen; i++) {
    //     table.find("tbody").append(MyRows[i]);
    //
    // }

    TBody.append(MyRows);

    if(data != "الكل") {

        for (var i = 0; i < RowLen; i++) {
            var result = false;
            var found = false;
            $(MyRows[i]).find('td').each(function () {
                var MyIndexValue = $(this).text();
                if (MyIndexValue.includes(data)) {
                    result = true;
                }
                else {
                    result = false;
                }

                found = (found || result);


            })

            if (!found) {
                $(MyRows[i]).remove();
            }


        }

    }
    TBody.paginate({ 'perPage': 5 });
}


function filter3() {
    // $(".table tbody tr").remove();
    var TBody=table.find("tbody");
    table.find("tbody tr").remove();
    TBody.data('paginate').kill();


    var name= page.find(".name-filt");
    var fontType=page.find(".fontType");
    var loc=page.find(".location");

    var nameVal= name.val();
    var fontTypeVal=fontType.val();
    var locVal=loc.val();

    var nameAtt=name.attr("filtercol");
    var fontAtt=fontType.attr("filtercol");
    var locAtt=loc.attr("filtercol");
    var x=0;

    TBody.append(MyRows);


    for (var i = 0; i < RowLen; i++) {
        var col=$(MyRows[i]).find("td");
        if (!( ( nameVal=="الكل" || col[nameAtt].innerHTML == nameVal ) &&(fontTypeVal=="الكل" || col[fontAtt].innerHTML ==fontTypeVal )&&(locVal=="الكل" || col[locAtt].innerHTML==locVal) )) {
            $(MyRows[i]).remove();

        }

    }
    TBody.paginate({ 'perPage': 5 });


}

function filter2(box1,box2) {
    var TBody=table.find("tbody");
    table.find("tbody tr").remove();
    TBody.data('paginate').kill();

    var box1Val= box1.val();
    var box2Val=box2.val();

    var  box1Att= box1.attr("filtercol");
    var box2Att=box2.attr("filtercol");
    var x=0;

    TBody.append(MyRows);


    for (var i = 0; i < RowLen; i++) {
        var col=$(MyRows[i]).find("td");
        if (!( ( box1Val=="الكل" || $(col[box1Att]).text() == box1Val)  && (box2Val=="الكل" || $(col[box2Att]).text() == box2Val  ) )) {
            $(MyRows[i]).remove();

        }

    }
    TBody.paginate({ 'perPage': 5 });


}

function Edittable(row,editbtn) {
    var savebtn=row.find(".save-edit");
    var td=row.find("td");
    // var date=row.find("input");
    editbtn.attr("hidden",true);
    savebtn.attr("hidden",false);
    td.attr("contenteditable",true);
    td.css({
    "box-sizing": "border-box ",
        "border": "2px inset #ccc",
    "border-radius": "4px",
        "padding":" 7px"

    });

    savebtn.click(function () {
        editbtn.attr("hidden",false);
        savebtn.attr("hidden",true);
    td.attr("contenteditable",false);
        td.css({
            "border": "none",
            "border-radius": "0",
            "padding":" 0"

        });

    })



}



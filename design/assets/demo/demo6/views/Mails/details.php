<?php  $this->load->view("header");?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">
<div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            تفاصيل الايميل
                                        </h3>
                                    </div>
                                </div>
</div>
<div class="contains">
    <div class="col-sm-12 CommentContainer">
<table class="table m-table ">
    <thead>
    <?php
        if ($MailDetails != null){?>
        <tr>
            <th>من :</th>
            <th>العنوان :</th>
            <th> الموضوع :</th>
        </tr>
    </thead>
    <tbody>
   
        <tr>
            <td scope="row"><?php echo get_Emp_name($MailDetails[0]->CrmMessagesFrom);?></td>
            <td> <?php echo $MailDetails[0]->CrmMessagesTitle;?> </td>
            <td><?php echo $MailDetails[0]->CrmMessagesContent;?></td>
        </tr>
    
    </tbody>
</table>
            <?php
        }
        ?>
    </div>
    </div>
</div>
    </div>
    </div>

</body>
</html>
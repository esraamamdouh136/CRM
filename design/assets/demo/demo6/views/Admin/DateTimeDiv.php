<div class="TODAY">
    <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-1 col-sm-12 text-center"> من تاريخ
        </label>
        <div class="col-lg-4 col-sm-12">
            <div class="input-group date">
                <!--                            <input type="text" class="form-control m-input" id="FromDate">-->
                <input value="<?= (isset($_SESSION['date1']))?$_SESSION['date1']:date("Y-m-d") ?>" type="text" id="FromDate" class="DatebakerInput form-control m-input">
                <div class="input-group-append" style="display: block;">
											<span class="input-group-text">
												<i class="flaticon-calendar glyphicon-th"></i>
											</span>
                </div>
            </div>

        </div>
        <label class="col-form-label col-lg-1 col-sm-12 text-center"> الى تاريخ
        </label>
        <div class="col-lg-4 col-sm-12">
            <div class="input-group date">
                <input value="<?= (isset($_SESSION['date2']))?$_SESSION['date2']:date("Y-m-d") ?>" type="text" id="ToDate" class="DatebakerInput form-control m-input mb-2">
                <div class="input-group-append" style="display: block;">
											<span class="input-group-text">
												<i class="flaticon-calendar glyphicon-th"></i>
											</span>
                </div>
            </div>

        </div>
        <div class="col-lg-2 col-sm-12">
            <button class="btn btn-info btn-sm btn-block Search" id="searchButton">بحث</button>
        </div>
    </div>
</div>
@extends('/layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تعديل دفعة دوائية </h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-left"></i>معلومات الدفعة</h4>
                    <form action="{{ route('drug.repo.update', $drug_repo->id) }}" method="POST">
                        @csrf
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">سعر المبيع للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_sell_price" value="{{$drug_repo->unit_sell_price}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">السعر الصافي للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_net_price" value="{{$drug_repo->unit_net_price}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">سعر المبيع للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_sell_price" value="{{$drug_repo->package_sell_price}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">السعر الصافي للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_net_price" value="{{$drug_repo->package_net_price}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">عدد الوحدات</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="units_number" value="{{$drug_repo->units_number}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">عدد العلب</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="packages_number" value="{{$drug_repo->packages_number}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ الانتاج</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="pro_date" value="{{$drug_repo->pro_date}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ انتهاء الصلاحية</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="exp_date" value="{{$drug_repo->exp_date}}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">تعديل</button>
                    </form>

                </div>
            </div>
            <!-- col-lg-12-->
        </div>
        <!-- /row -->
    </section>
    <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
@endsection

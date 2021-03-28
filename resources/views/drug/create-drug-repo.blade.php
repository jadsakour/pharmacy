@extends('layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left mr"></i>إضافة كمية معينة من  دواء إلى المخزن</h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-left mr"></i>معلومات مخزن الدواء</h4>
                    <form class="form-horizontal style-form" action="{{ route('drug.repo.store', $drug->id) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">اسم الدواء</label>
                            <div class="col-sm-4">
                                {{ $drug->name_arabic }}
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">عدد الوحدات في العلبة الواحدة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                          <label class="col-sm-2 control-label">عدد الوحدات</label>
                          <div class="col-sm-4">
                              <input type="text" class="form-control" name="units_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                          </div>
                          <label class="col-sm-2 control-label">عدد العلب</label>
                          <div class="col-sm-4">
                              <input type="text" class="form-control" name="packages_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                          </div>
                        </div>

                        <div class="form-group" dir="rtl">
                          <label class="col-sm-2 control-label">تاريخ انتهاء الصلاحية</label>
                          <div class="col-sm-4">
                              <input type="date" class="form-control" name="exp_date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                          </div>
                          <label class="col-sm-2 control-label">تاريخ الانتاج</label>
                          <div class="col-sm-4">
                              <input type="date" class="form-control" name="pro_date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                          </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 control-label">سعر المبيع للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_sell_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 control-label">السعر الصافي للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_net_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 control-label">سعر المبيع للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_sell_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 control-label">السعر الصافي للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_net_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-theme">إضافة</button>
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

@extends('layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left mr"></i>تعديل دواء</h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-left mr"></i>معلومات الدواء</h4>
                    <form class="form-horizontal style-form" action="{{ route('drug.update', $drug->id) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group " dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الاسم العربي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name_arabic" value="{{ $drug->name_arabic }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">الاسم الانكليزي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name_english" value="{{ $drug->name_english }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">التركيبة الكيميائية</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" value="{{ $drug->chemical_composition }}" name="chemical_composition"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">حجم العبوة </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="volume_unit" value="{{ $drug->volume_unit }}" />
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">رقم الترخيص الخاص بالمنتج الدوائي</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="lic_palte" value="{{ $drug->lic_palte }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الباركود المحلي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="local_barcode" value="{{ $drug->local_barcode }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الباركود</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="global_barcode" value="{{ $drug->global_barcode }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')" required>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الشركة</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="company_id">

                                    <option value="{{ $drug->company->id }}">{{ $drug->company->name }}</option>

                                </select>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الصنف</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="category_id">

                                    <option value="{{ $drug->category->id }}}">{{ $drug->category->name }}</option>

                                </select>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الشكل</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="shape_id">

                                    <option value="{{ $drug->shape->id }}">{{ $drug->shape->name }}</option>

                                </select>
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

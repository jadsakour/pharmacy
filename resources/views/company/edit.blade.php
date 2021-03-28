@extends('/layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" dir="rtl">
        <h3><i class="fa fa-angle-right"></i> تعديل معلومات شركة</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i>معلومات الشركة</h4>
                    <form action="{{ route('company.update', $company->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">اسم الشركة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" value="{{ $company->name }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">اسم مندوب الشركة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="delegate_name" value="{{ $company->delegate_name }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">رقم الهاتف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="phone" value="{{ $company->phone }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الفاكس</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="fax" value="{{ $company->fax }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">الموقع الالكتروني</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="web_site" value="{{ $company->web_site }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">البريد الالكتروني</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="email" value="{{ $company->email }}"  oninvalid="this.setCustomValidity('رجاء إدخال عنوان بريد إلكتروني صحيحي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                      >
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">العنوان</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" value="{{ $company->address }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">تعديل</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" >
        <h3><i class="fa fa-angle-right"></i>إضافة نوع فاتورة</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> معلومات</h4>
                    <form class="form-horizontal style-form" action="{{ route('accountingType.store') }}" method="POST">
                    @csrf
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">اسم النوع</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">إضافة النوع</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

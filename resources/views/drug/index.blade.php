@extends('layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right mr"></i> اختر أحد الخيارات التالية لعرض الأدوية المناسبة</h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <a type="submit" class="btn btn-theme mr " href="{{ route('drug.create.no.repo' )}}">إضافة دواء بلا مخزن</a>
                <a type="submit" class="btn btn-theme mr " href="{{ route('drug.create' )}}">إضافة دواء مع مخزن</a>
                <div class="form-panel">
                    <br>
                    <form class="form-horizontal style-form" action="{{ route('drug.filter') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group" dir="rtl">
                          <label class="col-sm-2 col-sm-2 control-label">الأشكال الدوائية</label>
                          <div class="col-sm-6">
                              <select class="form-control" name="shape">
                                  <option value="0" default>اختر شكل دوائي</option>
                                  @foreach ($shapes as $shape)
                                    <option value="{{ $shape->id }}">{{ $shape->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الأصناف الدوائية</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="category">
                                    <option value="0" default>اختر صنف</option>
                                    @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الشركات الدوائية</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="company">
                                    <option value="0" default>اختر شركة دوائية</option>
                                    @foreach ($companies as $company)
                                      <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-theme">عرض الأدوية</button>
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

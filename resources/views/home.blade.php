@extends('layouts.app')

@section('content')
<div class="container" id="firststep">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload Image') }}</div>

                <div class="card-body">

                    <form data-parsley-validate="" id="filesubmit" method="POST" action="javascript:void(0)" aria-label="{{ __('Upload Image') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- COMPONENT START -->
                        <div class="form-group">
                            <div class="input-group input-file" name="photo">
                                <input type="text" class="form-control" placeholder='Choose a file...' />           
                                <span class="input-group-append">
                                    <button class="btn btn-pink btn-choose" type="button">Choose</button>
                                </span>
                            </div>
                        </div>
                        <!-- COMPONENT END -->

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-indigo">
                                    {{ __('Upload') }} <i class="loader fa fa-circle-o-notch fa-spin d-none" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="overlay"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container d-none animated slideInLeft" id="secondstep">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Add Dimensions') }}</div>

                <div class="card-body">

                     <form action="javascript:void(0)" class="form-inline" id="cropform" data-parsley-validate="">
                          <div class="row">
                              <span>
                                <input data-parsley-type='digits' data-parsley-required-message='Please enter width' required="" type="input" name='width[]' class="form-control with"  placeholder="Width" style="margin-right: 10px"></span> 
                             <span>
                              <input data-parsley-type='digits' data-parsley-required-message='Please enter height' required="" type="input" name='height[]' class="form-control height" placeholder="Height" style="margin-right: 10px">
                             </span>
                          </div>
                         
                    </form> 
                    <a href="javascript:void(0)" id="goback1" class="btn btn-danger">Go Back</a>
                    <button type="submit" id="subform" class="btn btn-primary">Submit</button>
                    <button type="button" id="addfield" class="btn btn-purple">Add New</button>
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container  d-none animated slideInRight" id="thirdstep">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Download Auto Cropped Images') }}</div>

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6" id="outputimages"></div>
                    <div class="col-md-6" id="downloadall"> <a href="javascript:void(0)" class="btn btn-info downloadall">Download All</a> </div>
                    </div>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0)" id="goback2" class="btn btn-danger">Go Back</a>
                </div>
                

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    var url = "{{ url('showimage') }}";
    var storeurl = "{{ route('photos.store') }}";
    var downloadallurl = "{{ route('createzip') }}";
    var downloadallpath = "{{ url('downloadall') }}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js" integrity="sha256-XqEmjxbIPXDk11mQpk9cpZxYT+8mRyVIkko8mQzX3y8=" crossorigin="anonymous"></script>
<script src="{{asset('js/custom.js')}}"></script>
@endpush
@push('styles')
<style>
    #cropform {
     padding-left: 20px;
    }
    #cropform .row {
     margin-bottom: 10px;
    }
    #goback1 {
        margin-left: 4px;
    }
    .parsley-errors-list {
        color: red;
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .btn-bs-file{
        position:relative;
    }
    .btn-bs-file input[type="file"]{
        position: absolute;
        top: -9999999;
        filter: alpha(opacity=0);
        opacity: 0;
        width:0;
        height:0;
        outline: none;
        cursor: inherit;
    }
    .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        display: none;
    }
    #outputimages,#downloadall {
        text-align: center;
    }
    #outputimages a {
        margin-bottom: 10px;
    }
    #filesubmit .btn.btn-pink.btn-choose {
        margin: 0;
    }
    #cropform div.row button {
        margin:0;
    }
    #filesubmit .btn.btn-indigo {
        margin: 0;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" integrity="sha256-00w68NO3TLuHjKRHJmjrrgJBDtG/6OhbJEu1gtHcsuo=" crossorigin="anonymous" />
@endpush
@extends('back.layout.pages-layout')

@section('pageTitle',isset($pageTitle) ? $pageTilte : 'Settings')
@section('content')
    
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Setting
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-4">
    <h5 class="h4 text-blue mb-20">Default Tab</h5>
    @livewire('admin-settings')
</div>

@endsection
@push('scripts')
    <script>
        // $('input[type="file"][name="site_logo"][id="site_logo"]').ijaboViewer({
        //     preview: '#site_logo_view',
        //     imageShape : 'rectangular',
        //     allowedExtensions :['png','jpg'],
        //     onErrorShape:function(message, element){
        //         alert('message');
        //     },
        //     onInvalidType:function(message, element){
        //         alert('message');
        //     },
        //     onErrorSuccess:function(message, element){
                
        //     },

        // });
        $( '#change_site_logo_form ' ) .on( ' submit ' , function(e){
            e.preventDefault();
            var form . this;
            var formdata = new FormData(form);
            var inputFileVal = $(form).find('input[type="file"][name="site_logo"]').val();

            if( inputFileVal.length > 0){
                $.ajaX({
                url:$(form).attr('action'),
                nethod:$(form).attr('method'),
                data:formdata,
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                toastr.remove();
                $(form) .find( 'span.error-text' ).text(' ');
                },
                success:function(response){
                    if(response.status == 1){
                        toastr.success(response.msg);
                        $(form)[0].reset();
                    }else{
                        toastr.error(response.msg);
                    }
                }
            }):
            }else{
                $(form).find('span.error-text').text('please ,select logo image.PNG file recommended');
            }
        });
    </script>
    
@endpush
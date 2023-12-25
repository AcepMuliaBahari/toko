<div>
    @if($notification)
    <div class=" alert alert-success">
        {{ $notification }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    @endif
    @if($fail)
    <div class=" alert alert-danger">
        {{ $fail }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    @endif
    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a wire:click.prevent='selecTab("general_settings")' class="nav-link {{ $tab ==
                    'general_settings' ? 'active' : '' }}"   text-blue" data-toggle="tab" href="#general_settings"
                 role="tab" aria-selected="true">General Settings</a>
            </li>
            <li class="nav-item">
                <a wire:click.prevent='selecTab("logo_favicon")' class="nav-link {{ $tab ==
                    'logo_favicon' ? 'active' : '' }}"  text-blue" data-toggle="tab" href="#logo_favicon" 
                role="tab" aria-selected="false">Logo & Fav-icon</a>
            </li>
            <li class="nav-item">
                <a wire:click.prevent='selecTab("social_networks")' class="nav-link {{ $tab ==
                    'social_networks' ? 'active' : '' }}" class="nav-link text-blue" data-toggle="tab" href="#social_networks" 
                role="tab" aria-selected="false">Social Networks</a>
            </li>
            <li class="nav-item">
                <a wire:click.prevent='selecTab("payment_method")' class="nav-link {{ $tab ==
                    'payment_method' ? 'active' : '' }}" class="nav-link text-blue" data-toggle="tab" href="#payment_method" 
                role="tab" aria-selected="false">Payment Method</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab =='general_settings' ? 'active show' : '' }}" id="general_settings" role="tabpanel">
                <div class="pd-20">
                  <form wire:submit.prevent ='updateGeneralSettings()'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> <b>Site Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Site Name"
                                    wire:model.defer='site_name'>
                                    @error('site_name') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> <b>Site Email</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Site Email"
                                    wire:model.defer='site_email'>
                                    @error('site_email') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> <b>Site Phone</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Site Phone"
                                    wire:model.defer='site_phone'>
                                    @error('site_phone') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> <b>Kata Kunci Meta Situs</b> <small> Dipisahkan dengan koma (a,b,c)</small></label>
                                    <input type="text" class="form-control" placeholder="Enter Site Meta Keywords"
                                    wire:model.defer='site_meta_keywords'>
                                    @error('site_meta_keywords') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>                   
                        </div>
                        <div class="form-group">
                            <label for="">Site meta description</label>
                            <textarea  cols="4" rows="4" placeholder="site meta dess..."
                            class="form-control" wire:model.defer='site_meta_description'></textarea>
                            @error('site_meta_keywords') <span class="text-danger">{{ $message }}</span>
                                    @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"> Save </button>
                  </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab =='logo_favicon' ? 'active show' : '' }}" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                    <div class="col-md-6">
                        <h5> Site Logo</h5>
                        <div class="mb-2 mt-2" style="max-width : 200px;">
                            <img wire:ignore src="" class="img thumbnail" 
                            data-ijabo-default-img="/img/site/{{ $site_logo }}" id="site_logo_view">
                        </div>
                        <form action="{{ route('admin.change-favicon') }}" method="POST" enctype="multipart/form-data"
                        id="change_site_logo_form">
                        @csrf
                        <div class="mb-2">
                            <input type="file" name="site_logo" id="site_logo" class="form-control" 
                            onchange="document.getElementById('site_logo_view').src = window.URL.createObjectURL(this.files[0])">
                            <span class="text-danger error-text site_logo_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">change logo</button>
                    </form>
                    </div>
                    <div class="col-md-6">
                        <h5> Site favicon</h5>
                        <div class="mb-2 mt-2" style="max-width : 200px;">
                            <img wire:ignore src="" class="img thumbnail" 
                            data-ijabo-default-img="/img/site/{{ $site_favicon }}" id="site_favicon_view">
                        </div>
                        <form action="{{ route('admin.change-favicon') }}" method="POST" enctype="multipart/form-data"
                        id="change_site_favicon_form">
                        @csrf
                        <div class="mb-2">
                            <input type="file" name="site_favicon" id="site_favicon" class="form-control" 
                            onchange="document.getElementById('site_favicon_view').src = window.URL.createObjectURL(this.files[0])">
                            <span class="text-danger error-text site_favicon_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">change favicon</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab =='social_networks' ? 'active show' : '' }}" id="social_networks" role="tabpanel">
                <div class="pd-20">
                  ---so
                </div>
            </div>
            <div class="tab-pane fade {{ $tab =='payment_method' ? 'active show' : '' }}" id="payment_method" role="tabpanel">
                <div class="pd-20">
                  ---py
                </div>
            </div>
        </div>
    </div>
</div>

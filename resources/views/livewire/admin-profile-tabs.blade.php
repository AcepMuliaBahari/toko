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


    
    <div class="profile-tab height-100-p">
      
        <div class="tab height-100-p">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a wire:click.prevent='selecTab("personal_details")' class="nav-link {{ $tab ==
                    'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal Details</a>
                </li>
                <li class="nav-item">
                    <a wire:click.prevent='selecTab("update_password")' class="nav-link {{ $tab ==
                        'update_password' ? 'active' : '' }}" data-toggle="tab" href="#update_password" role="tab">Update Password</a>
                </li>
                
            </ul>
            <div class="tab-content">
                
                <!-- Timeline Tab start -->
                <div class="tab-pane fade {{ $tab =='personal_details' ? 'active show' : '' }}" id="personal_details" role="tabpanel">
                    <div class="pd-20">
                        
                        <form wire:submit.prevent='updateAdminPersonalDetails()'>
                           
                         
                            <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" wire:model='name' placeholder="Enter full name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" wire:model='email' placeholder="Enter Email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" class="form-control" wire:model='username' placeholder="Enter Username">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
                <!-- Timeline Tab End -->
                <!-- Tasks Tab start -->
                <div class="tab-pane fade {{ $tab ==
                    'update_password' ? 'active show' : '' }}" id="update_password" role="tabpanel">
                    <div class="pd-20 profile-task-wrap">
                        <form wire:submit.prevent='updatePassword()'>
                         
                            <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Current Password</label>
                                <input type="text" class="form-control" wire:model.defer='current_password' placeholder="Enter Current Password">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                           

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="texy" wire:model.defer='new_password'  class="form-control" placeholder="Enter new password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Confirm New Password</label>
                                <input type="text" class="form-control" wire:model.defer='new_password_confirmation' placeholder="Enter Confirm new password">
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

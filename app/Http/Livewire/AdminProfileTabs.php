<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminProfileTabs extends Component
{   
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'];
    public $notification;
    public $fail;
    public $name, $email, $username,$admin_id;
    public $current_password, $new_password, $new_password_confirmation;

    public function selecTab($tab){
        $this->tab = $tab;
    }
    public function mount(){
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
            $this->admin_id = $admin->id;
            $this->name = $admin->name;
            $this->email = $admin->email;
            $this->username = $admin->username;
        }
    }
    public function updateAdminPersonalDetails(){
        $this->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:admins,email,'.$this->admin_id,
            'username'=>'required|min:3|unique:admins,username,'.$this->admin_id,
        ]);
        Admin::find($this->admin_id)
            ->update([
                'name'=>$this->name,
                'email'=>$this->email,
                'username'=>$this->username,
            ]);
        $this->emit('UpdateAdminSellerHeaderProfileInfo');
        $this->dispatchBrowserEvent('updateAdminInfo',[
            'adminName'=>$this->name,
            'adminEmail'=>$this->email,
            // 'adminUsername'=>$this->username,
        ]);
      
    }
    //update password

        public function updatePassword()
        {
            $this->validate([
                'current_password' => [
                    'required', 
                    function($attribute, $value, $fail) {
                        if (!Hash::check($value, Admin::find(auth('admin')->id())->password)) {
                            return $fail(__('The current password is incorrect'));
                        }
                    }
                ],
                'new_password' => 'required|min:8|max:45|confirmed:new_password_confirmation',
            ]);

            $admin = Admin::findOrFail(auth('admin')->id());
            $admin->password = Hash::make($this->new_password);
            $query = $admin->save();
            

            if ($query) {
                // $_admin = Admin::findOrFail($this->admin_id);
                // $data = array(  
                //     'admin'=>$_admin,
                //     'new_password'=>$this->new_password
        
                //     );
        
                //     $mail_body = view('email-templates.admin-reset-email-template', $data)->render();
        
                //     $mailConfig = array(
                //     'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
                //     'mail_from_name'=>env('EMAIL_FROM_NAME'),
                //     'mail_recipient_email'=>$_admin->emai1,
                //     'mail-recipient_name'=>$_admin->name,
                //     'mail_subject'=>'Password changed',
                //     'mail_body' =>$mail_body
                //     );
        
                //     sendEmail($mailConfig);
                $this->current_password = $this->new_password = $this->new_password_confirmation = null;
                $this->notification = 'Update password successful';
            } else {
                $this->fail = 'Update password failed';
            }
        }

        
    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}

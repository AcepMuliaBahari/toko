<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use constDefaults;
use constGuards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function LoginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($fieldType == 'email'){
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' =>'required|min:8|max:45',    
            ],
            ['login_id.required'=> 'Email Or Username is diperlukan',
                'login_id.email'=> 'Invalid email address',
                'login_id.exists'=> 'Email Tidak Cocok',
                'password.required'=> 'Password Di Perlukan',

            ]);
        }else{
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' =>'required|min:8|max:45', 
            ],[
                'login_id.required'=> 'Email Or Username is diperlukan',
               
                'login_id.exists'=> 'Email Tidak Cocok',
                'password.required'=> 'Password Di Perlukan',

            ]);
        }
        $creds = array(
            $fieldType => $request->login_id,
            'password'=> $request->password,
        );
        if( Auth::guard('admin')->attempt($creds)){
            return redirect()->route('admin.home');
        }else{
            session()->flash('fail','Kredensial salah');
            return redirect()->route('admin.login');
        }
    }
    //logout
    public function LogoutHandler(Request $request){
        Auth::guard('admin')->logout();
        session()->flash('fail','Kamu Berhasil Logout!');
        return redirect()->route('admin.login');

    }//end
    //send Password reset link
    public function SendPasswordResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email',
            
        ],[
            'email.required'=> ' :attribute diperlukan',
            'email.email'=> 'Invalid Email address',
            'email.exists'=> ' :attribute tidak ada dalam sistem'
        ]);
        ///admin detail
        $admin = Admin::where('email',$request->email)->first();
        //generate token
        $token = base64_encode(Str::random(64));
        //check reset password token
        $oldToken = DB::table('password_resets')
            ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
            ->first();
        if($oldToken){
            //update token
            DB::table('password_resets')
            ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
            ->update([
                'token'=> $token,
                'created_at'=>Carbon::now()
            ]);
        }else{
            //add token
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at'=>Carbon::now()
            ]);
        }
        $actionLink = route('admin.reset-password',['token'=>$token,'email'=>$request->email]);
 
        $data = array(
            'actionLink'=> $actionLink,
            'admin'=>$admin,

        );
        
        $mail_body = view('email-templates.admin-forgot-email-template',$data)->render();
        $mailConfig = array(
            'mail_from_email'=> env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=> env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => ' Reset Password',
            'mail_body' => $mail_body
        );
        
        if( sendEmail($mailConfig) ){
            session()->flash('success','Kami telah mengirimkan tautan pengaturan ulang kata sandi Anda melalui email');
            return redirect()->route('admin.forgot-password');
        }else{
            session()->flash('fail','Ada yang salah!');
            return redirect()->route('admin.forgot-password');
        }
    }
    public function resetPassword(Request $request,$token = null){
        $check_token = DB::table('password_resets')
        ->where((['token'=>$token,'guard'=>constGuards::class]))
        ->first();
        
        if( $check_token ){
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s',$check_token->created_at)->diffInMinutes
            (Carbon::now());
            if ( $diffMins > constDefaults::tokenExpiredMinutes){
                session()->flash('fail',' Token expired!, minta tautan pengaturan ulang kata sandi lainnya');
                return redirect()->route('admin.forgot-password',['token'=>$token]);
            }else{
                return view('back.pages.admin.auth.reset-password')
                ->with(['token'=>$token]);
            }

        }else{
            session()->flash('fail','Invalid Token!, minta tautan pengaturan ulang kata sandi lainnya');
            return redirect()->route('admin.forgot-password',['token'=>$token]);

        }

    }

    public function resetPasswordHandler(Request $request){
        
        $request->validate([
            'new_password'=>'required|min:5|max:45|required_with:new_password_confirmation|
            same:new_password_confirmation',
            'new_password_confirmation'=>'required'
            
            ]);
            
            $token = DB::table('password_resets')
            
            ->where(['token'=>$request->token,'guard'=>constGuards::ADMIN])
            ->first();
            
            //Get admin details
            
            $admin = Admin::where('email',$token->email)->first();
            
            //update admin password
            
            Admin::where('email',$admin->email)->update([
            'password'=>Hash::make($request->new_password)
            
            ]);
            
            //delete token record
            
            DB::table('password_resets')->where([
            'email'=>$admin->email,
            'token'=>$request->token,
            'guard'=>constGuards::ADMIN
            
            ])->delete();
            //Sera emaiL to notify admin

            $data = array(  
            'admin'=>$admin,
            'new_password'=>$request->new_password

            );

            $mail_body = view('email-templates.admin-reset-email-template', $data)->render();

            $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$admin->emai1,
            'mail-recipient_name'=>$admin->name,
            'mail_subject'=>'Password changed',
            'mail_body' =>$mail_body
            );

            sendEmail($mailConfig);
            return redirect()->route('admin.login')->with('success','Berhasil!, password kamu berhasil terganti. gunakan
            password baru untuk login ke sistem.');
    }
    //profile
    public function ProfileView(Request $request){
        $admin = null; 
        if( Auth::guard('admin')->check() ){
        $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }
    //ubah fto
    public function ChangePhoto(Request $request){
        $admin = Admin::findOrFail(auth('admin')->id());
        $path = '/img/admins/';
        $file = $request->file('adminProfilePhotoFile');
        $old_photo = $admin->getAttributes()['photo'];
        $file_path = $path.$old_photo;
        $filename = 'ADMIN_IMG_'.rand(2,1000).$admin->id.time().uniqid().'.jpg';
        $upload = $file->move(public_path($path),$filename);

        if( $upload ){
            if( $old_photo != null && File::exists(public_path($path.$old_photo)) ){
                File::delete(public_path($path.$old_photo));
            }
            $admin->update(['photo'=>$filename]);
            return response()->json(['status'=>1,'msg'=>'your photo has been successfuuly updated']);
        }else{
            return response()->json(['status'=>0,'msg'=>'something went wrong.']);
        }
    }

    public function ChangeLogo(Request $request){
        $path = 'img/site/';
        $file = $request->file('site_logo');
        $settings = new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $file_path = $path.$old_logo;

        $filename = 'LOGO_'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(pubLic_path($path),$filename);

        if( $upload ){
            if( $old_logo != null && File::exists(public_path($path.$old_logo)) ){
                File::delete(public_path($path.$old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo = $filename;
            $update = $settings->save();
            return response()->json(['status'=>1,'msg'=>'Site logo has been updated successfully.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);         
        }
    
    }
    public function ChangeFavicon(Request $request){
        $path = 'img/site/';
        $file = $request->file('site_favicon');
        $settings = new GeneralSetting();
        $old_favicon = $settings->first()->site_favicon;
        $file_path = $path.$old_favicon;

        $filename = 'Fav_'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(pubLic_path($path),$filename);

        if( $upload ){
            if( $old_favicon != null && File::exists(public_path($path.$old_favicon)) ){
                File::delete(public_path($path.$old_favicon));
            }
            $settings = $settings->first();
            $settings->site_favicon = $filename;
            $update = $settings->save();
            return response()->json(['status'=>1,'msg'=>'Site logo has been updated successfully.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);         
        }

    }
}

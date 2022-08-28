<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Storage;

class ProfileController extends Controller {

    public function index() {
        return view('profile');
    }

    public function change_to_white_mode(Request $request) {
        User::where('id', \Auth::user()->id)->update(['color_mode' => 1]);
        return back();
    }

    public function change_to_dark_mode(Request $request) {
        User::where('id', \Auth::user()->id)->update(['color_mode' => 2]);
        return back();
    }

    public function update_profile(Request $request) {

        $input_all = $request->all();

        $validator = Validator::make($request->all(), [
                    'name' => 'required',
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {
            User::where('id', \Auth::user()->id)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเร็จ' . $e->getMessage();
        }

        return $return;
    }

    public function change_password_profile(Request $request) {

        $old_password = $request->input('old_password');
        $password = $request->input('password');

        $validator = Validator::make($request->all(), [
                    'old_password' => 'required',
                    'password' => 'required',
        ]);

        $return['title'] = 'เปลี่ยนรหัสผ่าน';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {

            $user = User::select('password')->where('id', \Auth::user()->id)->first();

            if (\Hash::check($old_password, $user->password)) {
                $new_password = \Hash::make($password);
                $data_update = [
                    'password' => $new_password,
                ];
                User::where('id', \Auth::user()->id)->update($data_update);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } else {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำเร็จ รหัสเก่าไม่ถูกต้อง';
            }
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำเร็จ' . $e->getMessage();
        }

        return $return;
    }

}

<?php

namespace App\Http\Controllers\Admin;

use stdClass;

use App\Models\Setting;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Admin\Setting\FreightRequest;

use App\Http\Requests\Admin\Setting\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Setting = Setting::select('id', 'setting', 'freight')->first();

        return view('admin.setting.index', ['Setting' => $Setting]);
    }

    /**
     * Display a listing of the resource.
     */
    public function configurations()
    {

        $Setting = Setting::select('id', 'configuration', 'company', 'smtp', 'aftership')->first();

        return view('admin.setting.configuration', ['Setting' => $Setting]);
    }

    /**
     * Display a listing of the resource.
     */
    public function config(Request $request, string $id)
    {

        $object = (object) $request->all();
        if (!isset($request->site_status)) {

            $object->{'site_status'} = 'off';
        }

        if (!isset($request->email_notification)) {

            $object->{'email_notification'} = 'off';
        }
        if (!isset($request->consolidate_status)) {

            $object->{'consolidate_status'} = 'off';
        }

        if (!isset($request->email_validation)) {

            $object->{'email_validation'} = 'off';
        }

        if (!isset($request->online_shop)) {

            $object->{'online_shop'} = 'off';
        }
        if (!isset($request->water_photo)) {

            $object->{'water_photo'} = 'off';
        }

        if (!isset($request->sub_icon)) {

            $object->{'sub_icon'} = 'off';
        }
        $Setting = Setting::findOrFail($id);

        $Setting->configuration = $object;

        $Setting->save();

        $notify = ['success' => "Configurations has been updated."];

        return $notify;
    }

    /**
     * Update the specified resource in storage.
     */
    public function setting(SettingRequest $request, string $id)
    {
        $object = (object) $request->all();

        $Setting = Setting::findOrFail($id);

        $Setting->setting = $object;

        $Setting->save();

        $notify = ['success' => "Settings has been updated."];

        return $notify;
    }

    /**
     * Update the specified resource in storage.
     */
    public function smtp(Request $request, string $id)
    {
        $object = (object) $request->all();

        $Setting = Setting::findOrFail($id);

        $Setting->smtp = $object;

        $Setting->save();

        $notify = ['success' => "Smtp has been updated."];

        return $notify;
    }

    /**
     * Update the specified resource in storage.
     */
    public function aftership(Request $request, string $id)
    {

        $object = (object) $request->all();

        if (!isset($request->status)) {

            $object->{'status'} = 'off';
        }

        $Setting = Setting::findOrFail($id);

        $Setting->aftership = $object;

        $Setting->save();

        $notify = ['success' => "Aftership has been updated."];

        return $notify;
    }

    /**
     * Update the specified resource in storage.
     */
    public function company(Request $request, string $id)
    {
        $object = new stdClass();

        $object->{'logo'} = $this->fileUpload($request->logo, 'logo.png');

        $object->{'favicon'} = $this->fileUpload($request->favicon, 'favicon.png');

        $object->{'watermark'} =  $this->fileUpload($request->watermark, 'watermark.png');

        $object->{'invoice'} = $this->fileUpload($request->invoice, 'invoice.png');

        $object->{'water_photo'} = $this->fileUpload($request->invoice, 'invoice.png');

        $object->{'online_shop'} =  $this->fileUpload($request->online_shop, 'online_shop.png');

        $Setting = Setting::findOrFail($id);

        $Setting->company = $object;

        $Setting->save();

        $notify = ['success' => "company has been updated."];

        return $notify;
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {

            if (Storage::exists('assets/company/' . $oldFile)) {

                Storage::Delete('assets/company/' . $oldFile);

                $file->storeAs('assets/company/', $oldFile);

                return $oldFile;
            } else {

                $file->storeAs('assets/company/', $oldFile);

                return $oldFile;
            }
        } else {

            return $oldFile;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function freight(FreightRequest $request, string $id)
    {

        $object = (object) $request->all();

        $Setting = Setting::findOrFail($id);

        $Setting->freight = $object;

        $Setting->save();

        $notify = ['success' => "Freight has been updated."];

        return $notify;
    }
}

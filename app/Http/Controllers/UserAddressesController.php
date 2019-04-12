<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressesRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        return view('user_addresses.index',[
           'addresses' => $request->user()->addresses
        ]);
    }

    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }

    public function store(UserAddressesRequest $request)
    {
        /**
         * $request->user() 获取当前登录用户。
            user()->addresses() 获取当前用户与地址的关联关系（注意：这里并不是获取当前用户的地址列表）
            addresses()->create() 在关联关系里创建一个新的记录。
            $request->only() 通过白名单的方式从用户提交的数据里获取我们所需要的数据。
         */
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }

    /**
     * 编辑展示
     * @param UserAddress $user_address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        return view('user_addresses.create_and_edit', ['address' => $user_address]);
    }

    /**
     * 编辑提交
     * @param UserAddress $userAddress
     * @param UserAddressesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserAddress $user_address, UserAddressesRequest $request)
    {
        $this->authorize('own', $user_address);
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }

    /**
     * 删除
     * @param UserAddress $user_address
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        $user_address->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }
}

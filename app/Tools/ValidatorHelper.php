<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/9/16
 * Time: 下午3:47
 */

namespace App\Tools;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidatorHelper
{
    /**
     * 对一个数组进行表单验证 , 错误在validator->errors()中 , 需要用$validator->fails()判断 , 不会报错
     * @param array $inputs
     * @param array $rules
     * @return mixed
     */
    public static function validateCheck(array $inputs, array $rules)
    {
        $validator = Validator::make($inputs,$rules);

        return $validator;
    }

    /**
     * 过滤掉恶意用户的多余参数 , 返回只存在rules key中的key元组
     * @param Request $request
     * @param array $rules
     * @return array
     */
    public static function getInputData(Request $request, array $rules)
    {
        $data = [];

        foreach ($rules as $key => $rule) {
            $data[$key] = $request->input($key,null);
        }

        return $data;
    }

    public static function checkAndGet(Request $request,array $rules)
    {
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => '表单验证出错'
            ]);
        }

        $data = [];

        foreach ($rules as $key => $rule) {
            $data[$key] = $request->input($key,null);
        }

        return $data;
    }
}
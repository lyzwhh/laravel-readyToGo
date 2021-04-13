<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/9/16
 * Time: 下午3:44
 */

namespace App\Tools;

use Illuminate\Support\Facades\Validator;

class ValidatorHelper
{
    /**
     * 对一个数组进行表单验证 , 错误在validator->fails()中 , 需要主动判断 , 不会报错
     * @param array $inputs
     * @param array $rules
     * @return mixed
     */
    public static function validateCheck(array $inputs,array $rules)
    {
        $validator = Validator::make($inputs,$rules);

        return $validator;
    }

    //  在controller中
    //  $check = ValidatorHelper::check($request->all(),$rules);
    //  if ($check)return $check;
    public static function check(array $inputs,array $rules)
    {
        $validator = Validator::make($inputs,$rules);

        if ($validator->fails())
        {
            return response([
                'code'  =>  -1,
                'msg'   =>  $validator->errors()
            ]);
        }
        return null;
    }

    /**
     * 过滤掉恶意用户的多余参数 , 返回只存在rules key中的key元组 , 方便直接数据库insert
     * @param array $inputData
     * @param array $rules
     * @return array
     */
    public static function getInputData(array $inputData,array $rules)
    {
        $setData = [];

        foreach ($rules as $key => $rule)
        {
            if (isset($inputData[$key]))
            {
                $setData[$key] = $inputData[$key];
            }
        }


        return $setData;
    }

    /**
     * 表单验证——第二版
     * 不支持rule中有层级如'ext.pic'

     * $setData = $validator = ValidatorHelper::validate($request->all(),$rules);
     * if (! is_array($setData))return $setData; //如果是数组$setData就是过滤后的参数，不是数组的话就是一个response

     * @param array $inputs
     * @param array $rules
     * @return mixed
     */
    public static function validate(array $inputs,array $rules)
    {
        $validator = Validator::make($inputs,$rules);

        if ($validator->fails())
        {
            return response([
                'code'  =>  -1,
                'msg'   =>  $validator->errors()
            ]);
        }
        else return self::getInputData($inputs,$rules);
    }
}
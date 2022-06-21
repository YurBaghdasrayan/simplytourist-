<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;


/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public static function getFields($slug,$context){
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // Check permission
        //$context->authorize('browse', app($dataType->model_name));
        $browserable_rows=[];
        foreach ($dataType->addRows as $field){
            if($field->browse){
                $browserable_rows[]=[
                    'field'=>$field->field,
                    'type'=>$field->type,
                    'display_name'=>$field->display_name
                ];
            }
        }
        return $browserable_rows;
    }
    public static function getInsertArray($browserable_rows,Request $request){
        $req = [];
        foreach ($browserable_rows as $row) {
            //По умолчанию как есть в $request поле
            $val = $request[$row['field']];
            //Нужно, чтобы не переписывать аватар
            $need_to_add = true;
            switch ($row['type']) {
                case 'checkbox':
                    if ($val == 'on')
                        $val = 1;
                    else
                        $val = 0;
                    break;
                case 'image':
                    if ($val) {
                        $val = $request->file($row['field'])->store('public/' . self::$slug);
                        $val = str_replace('public/', '', $val);
                    } else {
                        $need_to_add = false;
                    }
                    break;
                default:
            }
            if ($need_to_add) {
                $req += [
                    $row['field'] => $val
                ];
            }
        }
        return $req;
    }
    public static function getData($slug,$request,$query){
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $getter = $dataType->server_side ? 'paginate' : 'get';
        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', null);


        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($search->value && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }


        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }
        return $dataTypeContent;
    }
    public static function resizeImage($request,$inputName,$path,$maxWidth){
        $image=$request->file($inputName);
        $filename = $image->getClientOriginalName();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize($maxWidth,null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $destinationPath = 'public/'.$path.'';
        $image->storeAs($destinationPath, $filename);
//        $image_resize->save(storage_path('app/public/'.$path.'/' .$filename));

        return $path.'/'.$filename;
    }
}

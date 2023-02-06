<?php

//передаем класс получаем строку типа 'user,id' , что бы валидировать и не бояться смены названия таблицы у модели
function existByModel($class,$fieldName=null): string
{
    $entity = new $class;

    if (is_null($fieldName)){
        $fieldName = $entity->getKeyName();
    }

    return $entity->getTable().','.$fieldName;
}

//передаем класс получаем строку с названием таблицы
function uniqueByModel($class): string
{
    $entity = new $class;

    return $entity->getTable();
}

//поиск в объектах в определенном имени поля
function search_in_array_objects($needleString,$array,$unicField='name')
{
    try {
        foreach ($array as $item){
            if (strtolower($item[$unicField]) === strtolower($needleString)){
                return $item['id'];
            }
        }
    }catch (ErrorException $e){
        dd($needleString,$array,$unicField);
    }

};

function only_or_except($only,$except,$needle){
    return
        (empty($only) && empty($except))
        ||
        (!empty($only) && in_array($needle,$only))
        ||
        (!empty($except) && !in_array($needle,$except));
}

if (!function_exists('app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string $path
     * @return string
     */
    function app_path($path = '')
    {
        return app('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


/*
 * $customUses=['method'=>'post','uri'=>'any']
 * */
function reg_routes($name, $controllerName, $router, $only = [], $except = [], $customUses = [])
{

    $router->group([
        'prefix' => "/$name",
        'as' => $name,
    ], function () use ($router, $controllerName, $only, $except, $customUses) {

        foreach ($customUses as $item) {

            $customMethod = $item['method'];
            $customUri = $item['uri'];
            $patParamsUri ='';
            if (isset($item['pathParams']) && is_array($item['pathParams'])){
                foreach ($item['pathParams'] as $pathParamsItem){
                    $patParamsUri .='/{'. $pathParamsItem .'}';
                }
            }
            $action = '';
            $routName = '';

            foreach (explode('-', $customUri) as $keyUriItem => $uriItem) {
                if ($keyUriItem === 0) {
                    $action .= strtolower($uriItem);
                    $routName .= strtolower($uriItem);
                } else {
                    $action .= ucfirst(strtolower($uriItem));
                    $routName .= '_' . strtolower($uriItem);
                }

            }
            $router->$customMethod("/$customUri$patParamsUri", [
                'as' => $routName,
                'uses' => "$controllerName@$action"
            ]);
        }

        if (only_or_except($only, $except, 'index')) {
            $router->get('/', [
                'as' => 'index',
                'uses' => "$controllerName@index"
            ]);
        }
        if (only_or_except($only, $except, 'store')) {
            $router->post('/', [
                'as' => 'store',
                'uses' => "$controllerName@store"
            ]);
        }
        if (only_or_except($only, $except, 'show')) {
            $router->get("/{id}", [
                'as' => 'show',
                'uses' => "$controllerName@show"
            ]);
        }
        if (only_or_except($only, $except, 'update')) {
            $router->put("/{id}", [
                'as' => 'update',
                'uses' => "$controllerName@update"
            ]);
        }
        if (only_or_except($only, $except, 'update')) {
            $router->patch("/{id}", [
                'as' => 'update',
                'uses' => "$controllerName@update"
            ]);
        }
        if (only_or_except($only, $except, 'destroy')) {
            $router->delete("/{id}", [
                'as' => 'destroy',
                'uses' => "$controllerName@destroy"
            ]);
        }


    });

}

if(!function_exists('public_path'))
{
    /**
     * Return the path to public dir
     * @param null $path
     * @return string
     */
    function public_path($path=null)
    {
        return rtrim(app()->basePath('public/'.$path), '/');
    }
}

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

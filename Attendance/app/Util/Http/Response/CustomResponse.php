<?php

namespace App\Util\Http\Response;

abstract class CustomResponse{

    /**
     * Indicates the response's status code.
     * 
     * @var int
     */
    protected $status_code;

    /**
     * The response's parameters.
     * 
     * @var array
     */
    protected $response;

    protected const DEFAULT_ERROR_CODE = 401;
    protected const DEFAULT_SUCCESS_CODE = 201;

    private function __construct(){}

    /**
     * Creates a response factory
     * 
     * @param string $factory_name the factory's name
     * @return object
     */
    public static function make($factory_name = 'Json'){
        $factory = null;
        $factory_name = ucfirst($factory_name);
        $namespace = __NAMESPACE__;

        try{
            $factory_name = "$namespace\Custom${factory_name}Response";
            $factory = new $factory_name;
        } catch(Exception $exc){
            throw new InvalidArgumentException('Non-existing factory');
        }

        return $factory;
    }

    /**
     * Adds new parameter to the response.
     * 
     * The given parameter should be created and initialized with the given content
     * if it does not already exists, otherwise it should be updated with the given 
     * content (implementation-dependent).
     * 
     * @param string $param the parameter key
     * @param mixed $content the parameter value
     * @return object
     */
    public abstract function with($param, $content);

    /**
     * Returns the response array.
     * 
     * The response should use the given status code if it evaluates to a
     * truthy value, otherwise the internal status code (which is 201 by default)
     * should be used instead.
     * 
     * @param int|null $status_code the response's status code
     * @return array
     */
    public abstract function get($status_code = null);
}